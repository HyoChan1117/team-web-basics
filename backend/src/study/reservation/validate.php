<?php
function required(string $v): bool { return trim($v) !== ''; }
function phone_like(string $v): bool { return preg_match('/^[0-9+\-()\s]{6,20}$/', $v) === 1; }
function ymd(string $v): bool { return preg_match('/^\d{4}-\d{2}-\d{2}$/', $v) === 1; }
function time_slot_like(string $v): bool { return preg_match('/^\d{2}:\d{2}$/', $v) === 1; }
?>