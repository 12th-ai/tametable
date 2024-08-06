<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'create':
                create_TbEvents($_POST);
                break;
            case 'update':
                update_TbEvents($_POST['TbEventsID'], $_POST);
                break;
            case 'delete':
                delete_TbEvents($_POST['TbEventsID']);
                break;
        }
    }
}

function create_TbEvents($data) {
    global $pdo;
    $sql = "INSERT INTO TbEvents (Name, PhoneNumber, Department, TimeSlot, Day, Date, Action, Stream, Resource, TimeFrame, Notes_Comments, User_Creator) VALUES (:Name, :PhoneNumber, :Department, :TimeSlot, :Day, :Date, :Action, :Stream, :Resource, :TimeFrame, :Notes_Comments, :User_Creator)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($data);
}

function read_TbEvents() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM TbEvents");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function update_TbEvents($id, $data) {
    global $pdo;
    $data['id'] = $id;
    $sql = "UPDATE TbEvents SET Name = :Name, PhoneNumber = :PhoneNumber, Department = :Department, TimeSlot = :TimeSlot, Day = :Day, Date = :Date, Action = :Action, Stream = :Stream, Resource = :Resource, TimeFrame = :TimeFrame, Notes_Comments = :Notes_Comments, User_Creator = :User_Creator WHERE TbEventsID = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($data);
}

function delete_TbEvents($id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM TbEvents WHERE TbEventsID = :id");
    $stmt->execute(['id' => $id]);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $startTime = $_POST['start-time'];
    $endTime = $_POST['end-time'];
    $subjects = $_POST['subjects'];
    $numPeriods = $_POST['num-periods'];
    $durations = $_POST['durations'];
    $classLists = $_POST['class-lists'];
    $teachers = $_POST['teachers'];
    $colors = $_POST['colors'];
    $eventNames = $_POST['event-names'];
    $eventStartTimes = $_POST['event-start-times'];
    $eventEndTimes = $_POST['event-end-times'];
    $classStreams = $_POST['class-streams'];
    $classTeachers = $_POST['class-teachers'];
    $roomNames = $_POST['room-names'];

    $classStreamsData = [];
    foreach ($classStreams as $index => $classStream) {
        $classStreamsData[] = [
            'classStream' => $classStream,
            'teacher' => $classTeachers[$index],
            'room' => $roomNames[$index],
        ];
    }

    $subjectsData = [];
    foreach ($subjects as $index => $subject) {
        $subjectsData[] = [
            'subject' => $subject,
            'numPeriods' => (int)$numPeriods[$index],
            'duration' => (int)$durations[$index] * 60, // Convert to seconds
            'teacher' => $teachers[$index],
            'color' => $colors[$index],
        ];
    }

    $eventsData = [];
    foreach ($eventNames as $index => $eventName) {
        $eventsData[] = [
            'eventName' => $eventName,
            'startTime' => $eventStartTimes[$index],
            'endTime' => $eventEndTimes[$index],
        ];
    }

    $weekdays = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
    $timetable = [];
    foreach ($classStreamsData as $classStreamData) {
        $classStream = $classStreamData['classStream'];
        $timetable[$classStream] = array_fill_keys($weekdays, []);
    }

    function isOverlapping($startTime, $endTime, $events) {
        foreach ($events as $event) {
            if (
                (strtotime($startTime) >= strtotime($event['startTime']) && strtotime($startTime) < strtotime($event['endTime'])) ||
                (strtotime($endTime) > strtotime($event['startTime']) && strtotime($endTime) <= strtotime($event['endTime'])) ||
                (strtotime($startTime) <= strtotime($event['startTime']) && strtotime($endTime) >= strtotime($event['endTime']))
            ) {
                return true;
            }   
        }
        return false;
    }

    foreach ($classStreamsData as $classStreamData) {
        $classStream = $classStreamData['classStream'];
        if ( $weekdays = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday']){

        
        foreach ($eventsData as $event) {
            foreach ($weekdays as $day) {
                $timetable[$classStream][$day][] = [
                    
                    'subject' => $event['eventName'],
                    'startTime' => $event['startTime'],
                    'endTime' => $event['endTime'],
                    'teacher' => '',
                    'color' => '#f0f0f0',
                ];      
            }
        }
    }
    else{
          
        foreach ($eventsData as $event) {
            foreach ($weekdays as $day) {
                $timetable[$classStream][$day][] = [
                    
                    'startTime' => $event['startTime'],
                    'endTime' => $event['endTime'],
                    'teacher' => '',
                    'color' => '#f0f0f0',
                ];      
            }
        }
    }
    }

    function getAvailableSlots($startTime, $endTime, $duration, $events) {
        $availableSlots = [];
        $currentTime = strtotime($startTime);
        $endTimeTimestamp = strtotime($endTime);

        while ($currentTime + $duration <= $endTimeTimestamp) {
            $periodEndTime = $currentTime + $duration;
            $timeSlotStart = date('H:i', $currentTime);
            $timeSlotEnd = date('H:i', $periodEndTime);

            if (!isOverlapping($timeSlotStart, $timeSlotEnd, $events)) {
                $availableSlots[] = [
                    'startTime' => $timeSlotStart,
                    'endTime' => $timeSlotEnd,
                ];
            }

            $currentTime += $duration; // Move to the next potential slot
        }

        return $availableSlots;
    }

    foreach ($subjectsData as $subject) {
        $remainingPeriods = $subject['numPeriods'];

        foreach ($classStreamsData as $classStreamData) {
            $classStream = $classStreamData['classStream'];
            foreach ($weekdays as $day) {
                $availableSlots = getAvailableSlots($startTime, $endTime, $subject['duration'], $timetable[$classStream][$day]);

                foreach ($availableSlots as $slot) {
                    if ($remainingPeriods <= 0) break;

                    if (!isOverlapping($slot['startTime'], $slot['endTime'], $timetable[$classStream][$day])) {
                        $timetable[$classStream][$day][] = [
                            'subject' => $subject['subject'],
                            'startTime' => $slot['startTime'],
                            'endTime' => $slot['endTime'],
                            'teacher' => $subject['teacher'],
                            'color' => $subject['color'],
                        ];
                        $remainingPeriods--;    
                    }
                }

                if ($remainingPeriods <= 0) break;
            }
        }
    }

    foreach ($classStreamsData as $classStreamData) {
        $classStream = $classStreamData['classStream'];
        foreach ($weekdays as $day) {
            usort($timetable[$classStream][$day], function($a, $b) {
                return strtotime($a['startTime']) - strtotime($b['startTime']);
            });
        }
    }

    // Sort subjects and remove those from days that are not selected
    foreach ($classStreamsData as $classStreamData) {
        $classStream = $classStreamData['classStream'];
        foreach ($weekdays as $day) {
            $timetable[$classStream][$day] = array_filter($timetable[$classStream][$day], function($period) {
                return !empty($period['subject']); // Keep fixed events
            });
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generated Timetable</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.1.0/mdb.min.css">
    <style>
        .timetable-container {
            margin-top: 20px;
        }
        .timetable-table {
            width: 100%;
            border-collapse: collapse;
        }
        .timetable-table th, .timetable-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .timetable-table th {
            background-color: #f2f2f2;
        }
        .timetable-item {
            border-left: 10px solid;
            padding-left: 10px;
        }
        .fixed-event {
            background-color: #f0f0f0;
        }
    </style>
</head>
<body>
<div class="container timetable-container">
    <h1>Generated Timetable</h1>

    <?php foreach ($timetable as $classStream => $days): ?>
        <div class="class-stream">
            <h2>Timetable for <?= htmlspecialchars($classStream) ?></h2>
            <table class="table timetable-table">
                <thead>
                    <tr>
                        <th>Time Slot</th>
                        <?php foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'] as $day): ?>
                            <th><?= htmlspecialchars($day) ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                <?php
                $timeSlots = [];
                foreach ($days as $day => $periods) {
                    foreach ($periods as $period) {
                        $timeSlots[$period['startTime'] . '-' . $period['endTime']] = true;
                    }
                }
                $timeSlots = array_keys($timeSlots);
                sort($timeSlots);

                foreach ($timeSlots as $timeSlot) {
                    echo '<tr><td>' . htmlspecialchars($timeSlot) . '</td>';
                    foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'] as $day) {
                        $event = '';
                        foreach ($days[$day] as $period) {
                            if ($period['startTime'] . '-' . $period['endTime'] === $timeSlot) {
                                $event = $period['subject'] . '<br>Teacher: ' . $period['teacher'];
                                $colorClass = ' style="border-left-color: ' . htmlspecialchars($period['color']) . ';"';
                                $event = '<div class="timetable-item' . (empty($period['teacher']) ? ' fixed-event' : '') . '"' . $colorClass . '>' . $event . '</div>';
                                break;
                            }
                        }
                        echo '<td>' . $event . '</td>';
                    }
                    echo '</tr>';
                }   
                ?>
                </tbody>
            </table>
        </div>
    <?php endforeach; ?>
    <a href="Form.php" class="btn btn-secondary mt-3">Back to Form</a>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
