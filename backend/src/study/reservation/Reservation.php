<?php
declare(strict_types=1);

class ReservationMySQLi {
  private mysqli $db;
  public function __construct(mysqli $db) { $this->db = $db; }

  /** 날짜별 전체 조회 (null이면 최근 200개) */
  public function all(?string $date = null): array {
    if ($date) {
      $sql = "SELECT r.*, s.name AS service_name
              FROM reservation r
              JOIN service s ON s.service_id = r.service_id
              WHERE r.reservation_date = ?
              ORDER BY r.time_slot ASC";
      $stmt = $this->db->prepare($sql);
      if (!$stmt) throw new RuntimeException("쿼리 준비 실패");
      $stmt->bind_param("s", $date);
      $stmt->execute();
      $res = $stmt->get_result();
    } else {
      $sql = "SELECT r.*, s.name AS service_name
              FROM reservation r
              JOIN service s ON s.service_id = r.service_id
              ORDER BY r.reservation_date DESC, r.time_slot ASC
              LIMIT 200";
      $res = $this->db->query($sql);
    }
    $rows = $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
    if ($res instanceof mysqli_result) $res->free();
    return $rows;
  }

  /** 서비스 목록 */
  public function services(): array {
    $sql = "SELECT service_id, name FROM service ORDER BY service_id ASC";
    $res = $this->db->query($sql);
    $rows = $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
    if ($res instanceof mysqli_result) $res->free();
    return $rows;
  }

  /** 특정 날짜/서비스의 점유 슬롯 */
  public function occupiedSlots(string $date, int $serviceId): array {
    $sql = "SELECT time_slot FROM reservation
            WHERE reservation_date = ? AND service_id = ?";
    $stmt = $this->db->prepare($sql);
    if (!$stmt) throw new RuntimeException("쿼리 준비 실패");
    $stmt->bind_param("si", $date, $serviceId);
    $stmt->execute();
    $res = $stmt->get_result();
    $rows = $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
    if ($res instanceof mysqli_result) $res->free();
    return array_column($rows, 'time_slot');
  }

  /** 예약 생성 (UNIQUE 충돌 → RuntimeException 메시지로 변환) */
  public function create(array $data): int {
    $this->db->begin_transaction();
    try {
      $sql = "INSERT INTO reservation
              (service_id, customer_name, phone, reservation_date, time_slot, note)
              VALUES (?, ?, ?, ?, ?, ?)";
      $stmt = $this->db->prepare($sql);
      if (!$stmt) throw new RuntimeException("쿼리 준비 실패");

      // 타입: i s s s s s
      $service_id = (int)$data['service_id'];
      $customer_name = $data['customer_name'];
      $phone = $data['phone'];
      $reservation_date = $data['reservation_date'];
      $time_slot = $data['time_slot'];
      // NULL 허용: mysqli bind_param 에 NULL 전달 가능
      $note = $data['note'] !== '' ? $data['note'] : null;

      $stmt->bind_param(
        "isssss",
        $service_id,
        $customer_name,
        $phone,
        $reservation_date,
        $time_slot,
        $note
      );

      $ok = $stmt->execute();
      if (!$ok) {
        // 1062: duplicate entry (UNIQUE 제약 위반)
        if ($this->db->errno === 1062) {
          $this->db->rollback();
          throw new RuntimeException('이미 해당 시간에 예약이 있습니다.');
        }
        throw new RuntimeException("INSERT 실패: ".$this->db->error);
      }

      $newId = (int)$this->db->insert_id;
      $this->db->commit();
      return $newId;
    } catch (Throwable $e) {
      // 예외 발생 시 롤백 보장
      if ($this->db->errno) { $this->db->rollback(); }
      throw $e;
    }
  }
}

?>