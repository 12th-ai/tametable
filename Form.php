
<?php

// Uncomment and configure these lines if you need to include additional files or start output buffering
// $title = 'Manage Events';
// ob_start();
// require '../Packs/db_config.php';

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle the form submission based on the action specified
    if (isset($_POST['action']) && $_POST['action'] === 'create') {
        create_TbEvents($_POST);
    } elseif (isset($_POST['action']) && $_POST['action'] === 'update') {
        update_TbEvents($_POST['TbEventsID'], $_POST);
    } elseif (isset($_POST['action']) && $_POST['action'] === 'delete') {
        delete_TbEvents($_POST['TbEventsID']);
    }
}

// Function to create a new event
function create_TbEvents($data) {
    global $pdo;
    $sql = "INSERT INTO TbEvents (Name, PhoneNumber, Department, TimeSlot, Day, Date, Action, Stream, Resource, TimeFrame, Notes_Comments, User_Creator) VALUES (:Name, :PhoneNumber, :Department, :TimeSlot, :Day, :Date, :Action, :Stream, :Resource, :TimeFrame, :Notes_Comments, :User_Creator)";
    // $sql = "INSERT INTO TbEvents ( Day, Stream) VALUES (:subjects,num-periods,:durations,:class-lists,:teachers,:colors,:event-names,:event-start-times, :event-end-times, :class-streams,:class-teachers, :day,:)";
    $stmt = $pdo->prepare($sql);
    // Bind parameters
    $stmt->bindParam(':Name', $data['Name']);
    $stmt->bindParam(':PhoneNumber', $data['PhoneNumber']);
    $stmt->bindParam(':Depart 8m70w 5[ent', $data['Department']);
    $stmt->bindParam(':TimeSlot', $data['TimeSlot']);
    $stmt->bindParam(':Day', $data['Day']);
    $stmt->bindParam(':Date', $data['Date']);
    $stmt->bindParam(':Action', $data['Action']);
    $stmt->bindParam(':Stream', $data['Stream']);
    $stmt->bindParam(':Resource', $data['Resource']);
    $stmt->bindParam(':TimeFrame', $data['TimeFrame']);
    $stmt->bindParam(':Notes_Comments', $data['Notes_Comments']);
    $stmt->bindParam(':User_Creator', $data['User_Creator']);
    $stmt->execute();
}

// Function to read all events
function read_TbEvents() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM TbEvents");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Function to update an existing event
function update_TbEvents($id, $data) {
    global $pdo;
    $sql = "UPDATE TbEvents SET Name = :Name, PhoneNumber = :PhoneNumber, Department = :Department, TimeSlot = :TimeSlot, Day = :Day, Date = :Date, Action = :Action, Stream = :Stream, Resource = :Resource, TimeFrame = :TimeFrame, Notes_Comments = :Notes_Comments, User_Creator = :User_Creator WHERE TbEventsID = :id";
    $stmt = $pdo->prepare($sql);
    // Bind parameters
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':Name', $data['Name']);
    $stmt->bindParam(':PhoneNumber', $data['PhoneNumber']);
    $stmt->bindParam(':Department', $data['Department']);
    $stmt->bindParam(':TimeSlot', $data['TimeSlot']);
    $stmt->bindParam(':Day', $data['Day']);
    $stmt->bindParam(':Date', $data['Date']);
    $stmt->bindParam(':Action', $data['Action']);
    $stmt->bindParam(':Stream', $data['Stream']);
    $stmt->bindParam(':Resource', $data['Resource']);
    $stmt->bindParam(':TimeFrame', $data['TimeFrame']);
    $stmt->bindParam(':Notes_Comments', $data['Notes_Comments']);
    $stmt->bindParam(':User_Creator', $data['User_Creator']);
    $stmt->execute();
}

// Function to delete an event
function delete_TbEvents($id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM TbEvents WHERE TbEventsID = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
}

// Database connection settings
$host = 'localhost';
$dbname = 'time_table_generator';
$user = 'root';
$pass = '';

// Establish database connection
try {
    $pdos = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdos->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

// Function to fetch courses
function readCourses() {
    global $pdos;
    try {
        $stmt = $pdos->query("SELECT * FROM course");
        return $stmt;
    } catch (PDOException $e) {
        echo "Query failed: " . $e->getMessage();
        return false; 
    }
}

// Function to fetch teachers
function readteacher() {
    global $pdos;
    try {
        $stmt = $pdos->query("SELECT * FROM teacher");
        return $stmt;
    } catch (PDOException $e) {
        echo "Query failed: " . $e->getMessage();
        return false; 
    }
}

// Function to fetch classes
function readClass() {
    global $pdos;
    try {
        $stmt = $pdos->query("SELECT * FROM class");
        return $stmt;
    } catch (PDOException $e) {
        echo "Query failed: " . $e->getMessage();
        return false; 
    }
}

// Function to fetch class streams
function readClass_Stream() {
    global $pdos;
    try {
        $stmt = $pdos->query("SELECT * FROM class_stream");
        return $stmt;
    } catch (PDOException $e) {
        echo "Query failed: " . $e->getMessage();
        return false; 
    }
}

// Function to fetch fixed events
function readEvent() {
    global $pdos;
    try {
        $stmt = $pdos->query("SELECT * FROM fixed_event");
        return $stmt;
    } catch (PDOException $e) {
        echo "Query failed: " . $e->getMessage();
        return false; 
    }
}

// Function to fetch event start and end times
function readstart() {
    global $pdos;
    try {
        $stmt = $pdos->query("SELECT * FROM fixed_event ");
        return $stmt;
    } catch (PDOException $e) {
        echo "Query failed: " . $e->getMessage();
        return false; 
    }
}


function readend() {
    global $pdos;
    try {
        $stmt = $pdos->query("SELECT * FROM fixed_event ");
        return $stmt;
    } catch (PDOException $e) {
        echo "Query failed: " . $e->getMessage();
        return false; 
    }
}

// Fetching data for the form
$coursesStmt = readCourses();
$classStmt = readClass();
$teacherStmt = readteacher();
$teachersStmt = readteacher();
$classStream = readClass_Stream();
$eventstmt = readEvent();
$classestmt = readClass();
$eventstartstmt = readstart();
$eventendstmt = readend();

// Function to fetch events with their start and end times
function fetchEvents() {
    global $pdos;
    try {
        $stmt = $pdos->query("SELECT event_name, start_time, end_time FROM fixed_event");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Query failed: " . $e->getMessage();
        return [];
    }
}

$events = fetchEvents();

?>








<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Timetable Generator</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script>
    const eventsData = <?= json_encode($events) ?>;
</script>
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">Timetable Generator</h1>
    <form id="timetable-form" action="timetable.php" method="POST">
        <div class="form-row mb-4">
            <div class="form-group col-md-6">
                <label for="start-time">Start Time:</label>
                <input type="time" class="form-control" id="start-time" name="start-time">
            </div>
            <div class="form-group col-md-6">
                <label for="end-time">End Time:</label>
                <input type="time" class="form-control" id="end-time" name="end-time">
            </div>
        </div>
        <div class="form-group">
            <label for="subjects">Subjects:</label>
            <div id="subjects">
                <!-- Subjects will be added here -->
            </div>
            <button type="button" class="btn btn-secondary" id="add-subject"><i class="fas fa-plus"></i> Add Subject</button>
        </div>
        <div class="form-group">
            <label for="fixed-time-events">Fixed Time Events:</label>
            <div id="fixed-time-events">
                <!-- Fixed Time Events will be added here -->
            </div>
            <button type="button" class="btn btn-secondary" id="add-event"><i class="fas fa-plus"></i> Add Fixed Time Event</button>
        </div>
        <div class="form-group">
            <label for="class-streams">Class Streams:</label>
            <div id="class-streams">
                <!-- Class Streams will be added here -->
            </div>
            <button type="button" class="btn btn-secondary" id="add-class-stream"><i class="fas fa-plus"></i> Add Class Stream</button>
        </div>
        <button type="submit" class="btn btn-primary">Generate Timetable</button>
    </form>
</div>

<!-- Include MDB UI Kit JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.1.0/mdb.min.js"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.1.0/mdb.min.css">

<script>

    // wrapping formdata  {subject , course , class stream , teacher , fixed event data } to the form   starting point
document.getElementById('add-subject').addEventListener('click', function() {
    const subjectTemplate = `
        <div class="form-row align-items-end mb-2 subject-item">
            <div class="col-md-6">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-book"></i></span>
                    </div>
                    <select class="form-control" name="subjects[]" >
    <option value="">Select a Course</option>
    <?php while ($course = $coursesStmt->fetch(PDO::FETCH_ASSOC)): ?>
        <option value="<?= htmlspecialchars($course['course_name']) ?>" <?= isset($_GET['course_name']) && $_GET['course_name'] == $course['course_name'] ? 'selected' : '' ?>>
            <?= htmlspecialchars($course['course_name']) ?>
        </option>
    <?php endwhile; ?>
</select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-sort-numeric-up"></i></span>
                    </div>
                    <input class="form-control" type="number" placeholder="Number of Periods per Week" name="num-periods[]">
                </div>
            </div>
            <div class="col-md-6">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-clock"></i></span>
                    </div>
                    <input class="form-control" type="number" placeholder="Duration (minutes)" name="durations[]">
                </div>
            </div>
            <div class="col-md-6">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-building"></i></span>
                    </div>
                    <select class="form-control" name="class-lists[]">
    <option value="">Select a Class</option>
    <?php while ($class = $classStmt->fetch(PDO::FETCH_ASSOC)): ?>
        <option value="<?= htmlspecialchars($class['class_name']) ?>" <?= isset($_GET['class_name']) && $_GET['class_name'] == $class['class_name'] ? 'selected' : '' ?>>
            <?= htmlspecialchars($class['class_name']) ?>
        </option>
    <?php endwhile; ?>
</select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                    </div>
                    <select class="form-control" name="teachers[]">

    <option value="">Select a Teacher</option>
    <?php while ($teacher = $teacherStmt->fetch(PDO::FETCH_ASSOC)): ?>
        <option value="<?= htmlspecialchars($teacher['teacher_name']) ?>" <?= isset($_GET['teacher_name']) && $_GET['teacher_name'] == $teacher['teacher_name'] ? 'selected' : '' ?>>
            <?= htmlspecialchars($teacher['teacher_name']) ?>
        </option>
    <?php endwhile; ?>
</select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-palette"></i></span>
                    </div>
                    <input type="color" class="form-control" name="colors[]">
                </div>
            </div>
            <div class="col-md-1 d-flex align-items-center">
                <button type="button" class="btn btn-danger remove-subject"><i class="fas fa-trash"></i></button>
            </div>
        </div>
    `;
    document.getElementById('subjects').insertAdjacentHTML('beforeend', subjectTemplate);
    attachRemoveSubjectListeners();
});







document.getElementById('add-event').addEventListener('click', () => {
    const eventTemplate = `
        <div class="form-row align-items-end mb-2">
            <div class="col-md-4">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                    </div>
                    <select class="form-control event-name" name="event-names[]" onchange="updateTimes(this)">
                        <option value="">Select Event</option>
                        ${eventsData.map(event => `<option value="${event.event_name}">${event.event_name}</option>`).join('')}
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-clock"></i></span>
                    </div>
                    <select class="form-control event-start-time" name="event-start-times[]">
                   
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-clock"></i></span>
                    </div>
                    <select class="form-control event-end-time" name="event-end-times[]">
                      
                    </select>
                </div>
            </div>
            <div class="col-md-1 d-flex align-items-center">
                <button type="button" class="btn btn-danger remove-event"><i class="fas fa-trash"></i></button>
            </div>
        </div>
    `;
        // wrapping formdata  {subject , course , class stream , teacher , fixed event data } to the form   ending  point
    document.getElementById('fixed-time-events').insertAdjacentHTML('beforeend', eventTemplate);
    attachRemoveEventListeners();
});

// javascrip function to wrapping realtime fixed event data  starting point

function updateTimes(selectElement) {
    const selectedEventName = selectElement.value;
    const row = selectElement.closest('.form-row');
    const startTimeSelect = row.querySelector('.event-start-time');
    const endTimeSelect = row.querySelector('.event-end-time');

    

    const event = eventsData.find(e => e.event_name === selectedEventName);
    if (event) {
        startTimeSelect.innerHTML += `<option value="${event.start_time}">${event.start_time}</option>`;
        endTimeSelect.innerHTML += `<option value="${event.end_time}">${event.end_time}</option>`;
    }
}

// javascript function to wrapping realtime fixed event data  ending point



function attachRemoveEventListeners() {
    document.querySelectorAll('.remove-event').forEach(button => {
        button.addEventListener('click', function() {
            this.closest('.form-row').remove();
        });
    });
}


// jsavascript function to select and wrapping  class stream  data with pdo and wrapping to form with php 


document.getElementById('add-class-stream').addEventListener('click', function() {
    const classStreamTemplate = `
        <div class="form-row align-items-end mb-2 class-stream-item">
            <div class="col-md-3">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-school"></i></span>
                    </div>

<select class="form-control" name="class-streams[]"> >
    <option value="">Select a Class</option>
    <?php while ($classe = $classestmt->fetch(PDO::FETCH_ASSOC)): ?>
        <option value="<?= htmlspecialchars($classe['class_name']) ?>" <?= isset($_GET['class_name']) && $_GET['class_name'] == $classe['class_name'] ? 'selected' : '' ?>>
            <?= htmlspecialchars($classe['class_name']) ?>
        </option>
    <?php endwhile; ?>
</select>
                    

                </div>
            </div>
            <div class="col-md-3">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                    </div>
                    <select class="form-control" name="class-teachers[]">
                    

<option value="">Select a Teacher</option>

// jsavascript function to select and wrapping  teacher   data with pdo and wrapping to form with php 
<?php while ($teachers = $teachersStmt->fetch(PDO::FETCH_ASSOC)): ?>
    <option value="<?= htmlspecialchars($class['teacher_name']) ?>" <?= isset($_GET['teacher_name']) && $_GET['teacher_name'] == $teachers['teacher_name'] ? 'selected' : '' ?>>
        <?= htmlspecialchars($teachers['teacher_name']) ?>
    </option>
<?php endwhile; ?>
</select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-door-open"></i></span>
                    </div>
                    <select class="form-control" name="room-names[]">
                    <option value="">Select class stream</option>

                    
<?php while ($class_stream = $classStream->fetch(PDO::FETCH_ASSOC)): ?>
    <option value="<?= htmlspecialchars($class_stream['class_stream_name']) ?>" <?= isset($_GET['class_stream_name']) && $_GET['class_stream_name'] == $class_stream['class_stream_name'] ? 'selected' : '' ?>>
        <?= htmlspecialchars($class_stream['class_stream_name']) ?>
    </option>
<?php endwhile; ?>
</select>
                   
                </div>
            </div>
            <div class="col-md-3">
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-mdb-toggle="dropdown" aria-expanded="false">
                        Select Days
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <li>
                            <a class="dropdown-item" href="#">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="Monday" id="dayMonday" name="day[]" />
                                    <label class="form-check-label" for="dayMonday">Monday</label>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="Tuesday" id="dayTuesday" />
                                    <label class="form-check-label" for="dayTuesday">Tuesday</label>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="Wednesday" id="dayWednesday" />
                                    <label class="form-check-label" for="dayWednesday">Wednesday</label>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="Thursday" id="dayThursday" />
                                    <label class="form-check-label" for="dayThursday">Thursday</label>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="Friday" id="dayFriday" />
                                    <label class="form-check-label" for="dayFriday">Friday</label>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-1 d-flex align-items-center">
                <button type="button" class="btn btn-danger remove-class-stream"><i class="fas fa-trash"></i></button>
            </div>
        </div>
    `;
    document.getElementById('class-streams').insertAdjacentHTML('beforeend', classStreamTemplate);
    attachRemoveClassStreamListeners();
});

// Function to initialize the MDB dropdown with checkboxes
document.addEventListener('DOMContentLoaded', function () {
    const dropdowns = document.querySelectorAll('.dropdown-menu');
    dropdowns.forEach(dropdown => {
        const dropdownToggle = dropdown.previousElementSibling;
        dropdownToggle.addEventListener('click', () => {
            dropdown.classList.toggle('show');
        });
    });
});

function attachRemoveEventListeners() {
    document.querySelectorAll('.remove-event').forEach(function(button) {
        button.addEventListener('click', function() {
            this.closest('.form-row').remove();
        });
    });
}

function attachRemoveSubjectListeners() {
    document.querySelectorAll('.remove-subject').forEach(function(button) {
        button.addEventListener('click', function() {
            this.closest('.subject-item').remove();
        });
    });
}

function attachRemoveClassStreamListeners() {
    document.querySelectorAll('.remove-class-stream').forEach(function(button) {
        button.addEventListener('click', function() {
            this.closest('.form-row').remove();
        });
    });
}

// Initial call to attach event listeners to already existing elements (if any)
attachRemoveEventListeners();
attachRemoveSubjectListeners();
attachRemoveClassStreamListeners();
</script>
</body>



</html>













<?php
//including the template structure
// $content = ob_get_clean();
// include '../app/template.php';
?>