<?php

require __DIR__ . '/../vendor/autoload.php';

// 라우터 등록 함수 선언
function studentRegister(AltoRouter $router): AltoRouter {
    $router->map('GET', '/', fn() => 'Home Page');  // root 경로 테스트용

    $router->map('GET', '/students', 'StudentsController#index');  // 전체 목록 조회
    $router->map('GET', '/students/[i:std_id]', 'StudentsController#show');   // 개별 학생 조회    
    $router->map('POST', '/students', 'StudentsController#create');   // 새 학생 등록    
    $router->map('PUT', '/students/[i:std_id]', 'StudentsController#update');   // 학생 정보 수정   
    $router->map('PATCH',  '/students/[i:std_id]',     'StudentsController#update');
    $router->map('DELETE', '/students/[i:std_id]', 'StudentsController#delete');   // 학생 삭제

    return $router;   // AltoRouter형으로 반환
}

$router = new AltoRouter();   // 라우터 인스턴스 생성
$router->setBasePath('');   // 기본 경로 설정
studentRegister($router);   // 라우트 등록 함수 호출

// 매칭
// 현재 요청 경로(ex: /students/12)와 현재 요청 메서드(ex: GET)
// 위에서 등록한 라우트 목록과 비교
// -> 일치하는 항목을 찾으면 $match 배열을 반환
/*
- 값을 성공적으로 불러왔을 경우
$match = [
            'target' => 'StudentsController#show',
            'params' => ['std_id' => 12],
            'name' => null
        ];

- 실패했을 경우
$match = false;
*/
$match = $router->match();

// 해당하는 
if ($match) {
    $target = $match['target'];

    if (is_callable($target)) {
        $result = call_user_func_array($target, $match['params']);
        if (is_string($result)) {
            // 문자 반환 시에만 안전하게 출력
            echo json_response([$result]);
        }
    } elseif (is_string($target) && strpos($target, '#') !== false) {
        // "Controller#method" 형태 지원 (선택)
        [$controller, $method] = explode('#', $target, 2);
        $fqcn = "\\App\\Controllers\\{$controller}";
        (new $fqcn())->{$method}(...array_values($match['params']));
    } else {
        echo json_response(['error' => 'Bad route target'], 500);
    }
} else {
    echo json_response(['error' => '404 Not Found'], 404);
}