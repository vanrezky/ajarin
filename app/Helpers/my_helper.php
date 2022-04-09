<?php

function pesan($status = "success", $pesan)
{

    return '<div class="alert alert-' . $status . ' alert-dismissible fade show" role="alert">
                ' . $pesan . '
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>';
}

function p($data)
{
    echo '<pre>' . var_export($data, true) . '</pre>';
}

function pp($data)
{
    echo '<pre>' . var_export($data, true) . '</pre>';
    die;
}

function gantiUri($link)
{
    return ucwords(str_replace(['-', '_'], ' ', $link));
}


function teacher_homebases()
{
    return $base = [
        'english_language' => 'English Language',
        'mathematics' => 'Mathematics'
    ];
}


function teacher_homebase($var)
{
    $base = teacher_homebases();

    if (array_key_exists($var, $base)) {
        return $base[$var];
    }

    return 'Unknown';
}

function show_404($msg = null)
{
    throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound($msg);
}

function discuss_status($var)
{

    if ($var == 0) {
        return "Not Started";
    } elseif ($var == 1) {
        return "Started";
    } else {
        return "Finish";
    }
}

function current_timestamp()
{
    date_default_timezone_set("Asia/Jakarta");
    return date("Y-m-d H:i:s");
}


function expired($date, $quantity, $duration = "30")
{

    return date("Y-m-d H:i:s", strtotime($date . "+" . ($duration * $quantity) . " minutes"));
}

function igDate($datetime)
{
    $time_ago        = strtotime($datetime);
    $current_time    = time();
    $time_difference = $current_time - $time_ago;
    $seconds = $time_difference;
    $minutes = round($seconds / 60);       // value 60 is seconds
    $hours   = round($seconds / 3600);      // value 3600 is 60 minutes * 60 sec
    $days    = round($seconds / 86400);     // 86400 = 24*60*60;
    $weeks   = round($seconds / 604800);    // 7*24*60*60;
    $months  = round($seconds / 2629440);   // ((365+365+365+365+366)/5/12)*24*60*60
    $years   = round($seconds / 31553280);  // (365+365+365+365+366)/5*24*60*60

    if ($seconds <= 60) {
        return "baru saja";
    } elseif ($minutes <= 60) {
        if ($minutes == 1) {
            return "1 menit yang lalu";
        } else {
            return "$minutes menit yang lalu";
        }
    } elseif ($hours <= 24) {
        if ($hours == 1) {
            return "1 jam yang lalu";
        } else {
            return "$hours jam yang lalu";
        }
    } elseif ($days <= 7) {
        if ($days == 1) {
            return "kemarin";
        } else {
            return "$days hari yang lalu";
        }
    } elseif ($weeks <= 4.3) { //4.3 == 52/12
        if ($weeks == 1) {
            return "1 minggu yang lalu";
        } else {
            return "$weeks minggu yang lalu";
        }
    } elseif ($months <= 12) {
        if ($months == 1) {
            return "1 bulan yang lalu";
        } else {
            return "$months bulan yang lalu";
        }
    } else {
        if ($years == 1) {
            return "1 tahun yang lalu";
        } else {
            return "$years tahun yang lalu";
        }
    }
}


function transaction($trans)
{
    $veritrans = service('Veritrans');

    $transactionM = new \App\Models\TransactionModel();
    $update = [];
    foreach ($trans as $key => $value) {

        if ($value['status_code'] != 200) {
            $status = (array) $veritrans->getStatus($value['transaction_id']);
        } else {
            $status = $value;
        }

        if ($status['status_code'] != 404) {

            $dateStart = $value['discuss_date'];
            $discussStatus = $value['discuss_status'];

            $today = current_timestamp();

            if ($status['status_code'] == 200 && $discussStatus == 0) {
                $dateStart = $today;
                $discussStatus = 1;
            }


            $expired = expired($value['discuss_date'], $value['quantity']);
            if ($today > $expired) {
                $discussStatus = 2;
            }

            $trans[$key]['status_code'] = $status['status_code'];
            $trans[$key]['transaction_status'] = $status['transaction_status'];
            $trans[$key]['discuss_date'] =  $dateStart;
            $trans[$key]['discuss_status'] = $discussStatus;

            $update[] = [
                'transaction_id' => $value['transaction_id'],
                'status_code' => $status['status_code'],
                'transaction_status' => $status['transaction_status'],
                'transaction_json' => json_encode($status),
                'discuss_date' => $dateStart,
                'discuss_status' => $discussStatus,
            ];
        } else {
            $update[] = [
                'transaction_id' => $value['transaction_id'],
                'status_code' => $status['status_code'],
                'transaction_status' => 'not_found'
            ];
        }
    }

    if (!empty($update)) {
        $transactionM->updateBatch($update, 'transaction_id');
    }


    return $trans;
}
