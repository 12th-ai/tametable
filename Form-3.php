
<?php

$title = 'Manage Events';
ob_start();

require '../Packs/db_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'create') {
        create_TbEvents($_POST);
    } elseif (isset($_POST['action']) && $_POST['action'] === 'update') {
        update_TbEvents($_POST['TbEventsID'], $_POST);
    } elseif (isset($_POST['action']) && $_POST['action'] === 'delete') {
        delete_TbEvents($_POST['TbEventsID']);
    }
}

function create_TbEvents($data) {
    global $pdo;
    $sql = "INSERT INTO TbEvents (Name, PhoneNumber, Department, TimeSlot, Day, Date, Action, Stream, Resource, TimeFrame, Notes_Comments, User_Creator) VALUES (:Name, :PhoneNumber, :Department, :TimeSlot, :Day, :Date, :Action, :Stream, :Resource, :TimeFrame, :Notes_Comments, :User_Creator)";
    $stmt = $pdo->prepare($sql);
    // Bind parameters
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
function read_TbEvents() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM TbEvents");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
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
function delete_TbEvents($id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM TbEvents WHERE TbEventsID = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Timetable Generator</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
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

<script>
document.getElementById('add-subject').addEventListener('click', function() {
    const subjectTemplate = `
        <div class="form-row align-items-end mb-2 subject-item">
            <div class="col-md-6">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-book"></i></span>
                    </div>
                    <select class="form-control" name="subjects[]">
                        <option value="Math">Math</option>
                        <option value="Science">Science</option>
                        <option value="English">English</option>
                        <option value="History">History</option>
                        <option value="Geography">Geography</option>
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
                        <option value="Class 1">Class 1</option>
                        <option value="Class 2">Class 2</option>
                        <option value="Class 3">Class 3</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                    </div>
                    <select class="form-control" name="teachers[]">
                        <option value="Teacher 1">Teacher 1</option>
                        <option value="Teacher 2">Teacher 2</option>
                        <option value="Teacher 3">Teacher 3</option>
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

document.getElementById('add-event').addEventListener('click', function() {
    const eventTemplate = `
        <div class="form-row align-items-end mb-2">
            <div class="col-md-4">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                    </div>
                    <input class="form-control" type="text" placeholder="Event Name" name="event-names[]">
                </div>
            </div>
            <div class="col-md-4">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-clock"></i></span>
                    </div>
                    <input type="time" class="form-control" name="event-start-times[]">
                </div>
            </div>
            <div class="col-md-4">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-clock"></i></span>
                    </div>
                    <input type="time" class="form-control" name="event-end-times[]">
                </div>
            </div>
            <div class="col-md-1 d-flex align-items-center">
                <button type="button" class="btn btn-danger remove-event"><i class="fas fa-trash"></i></button>
            </div>
        </div>
    `;
    document.getElementById('fixed-time-events').insertAdjacentHTML('beforeend', eventTemplate);
    attachRemoveEventListeners();
});

document.getElementById('add-class-stream').addEventListener('click', function() {
    const classStreamTemplate = `
        <div class="form-row align-items-end mb-2 class-stream-item">
            <div class="col-md-3">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-school"></i></span>
                    </div>
                    <select class="form-control" name="class-streams[]">
                        <option value="Class 1">Class 1</option>
                        <option value="Class 2">Class 2</option>
                        <option value="Class 3">Class 3</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                    </div>
                    <select class="form-control" name="class-teachers[]">
                        <option value="Teacher 1">Teacher 1</option>
                        <option value="Teacher 2">Teacher 2</option>
                        <option value="Teacher 3">Teacher 3</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-door-open"></i></span>
                    </div>
                    <input class="form-control" type="text" placeholder="Room Name" name="room-names[]">
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
                                    <input class="form-check-input" type="checkbox" value="Monday" id="dayMonday" />
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
$content = ob_get_clean();
include '../app/template.php';
?>