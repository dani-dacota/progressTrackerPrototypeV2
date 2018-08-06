<?php
    include 'json.php';

    $projects = array("USMLE", "Blank");
    $projectId = $_POST["id"];
    
    if ($projects[$projectId] == "USMLE"){
        
        $data = readJSON();
        $day = 0;
        $progressArr = $data["progress"];
        $total = $data["total"];
        $dueDate = $data["date"];
        $qsLeft = $total;
        $qsDone = 0;
        
        $progress = "";
        $form = "";
        $lastDate = "";
        
        ksort($progressArr);
        
        foreach($progressArr as $date=>$progressData){
            $class = "card";
            $dateObj =date_create($date);
            $dateFormatted = date_format($dateObj,"d/m/Y");
            $today = time();
            $difference = strtotime($date) - $today;
            if ($difference > 0) { $class = "card future"; }
            $qs = $progressData["qs"];
            $notes = $progressData["notes"];
            $qsLeft = $qsLeft - $qs;
            $qsDone += $qs;
            $percent = round($qsDone*100/$total,1);
            $day +=1;
            $card = "";
            
            
            $card .= "\n<div class=\"$class\" id=\"$date\" onClick=\"showForm(this)\">";
            $card .= "\n\t<h2>Day#$day</h2>";
            $card .= "\n\t<h3>$dateFormatted</h3>";
            $card .= "\n\t<p>Qs: $qs</p>";
            $card .= "\n\t<p>Tally: $qsDone</p>";
            $card .= "\n\t<meter value =\"" . $qsDone .  "\" max= \"$total\" min=\"0\"></meter>";
            $card .= "\n\t<p class=\"overlay\">$percent%</p>";
            $card .= "\n</div>";
            
            $progress = $card . $progress;
            
            $form .= "\n\t<form id=\"$date-form\" class=\"progress-form\">";
            $form .= "\n\t\t\t<h2>Update Progress</h2>";
            $form .= "\n\t\t\t<label>Date:</label>";
            $form .= "\n\t\t\t<input type=\"date\" name=\"date\" value=\"$date\" required>";
            $form .= "\n\t\t\t<label>Qs:</label>";
            $form .= "\n\t\t\t<input type=\"number\" name=\"qs\" min=\"1\" value=\"$qs\"required>";
            $form .= "\n\t\t\t<label>Notes:</label>";
            $form .= "\n\t\t\t<textarea name=\"notes\" form=\"$date-form\" placeholder=\"Enter notes here...\">$notes</textarea>";
            $form .= "\n\t\t<input type=\"hidden\" name=\"project-id\" value=\"$projectId\">";
            $form .= "\n\t\t<input type=\"button\" form=\"$date-form\" value=\"Update\" onClick=\"formSubmit(this)\">";
            $form .= "\n\t\t<input type=\"button\" form=\"$date-form\" value=\"Delete\" onClick=\"formSubmit(this)\">";
            $form .= "\n\t</form>";
            
        }

    }


    $card = "";
    
    $card .= "\n<div class=\"card\" id=\"new\" onClick=\"showForm(this)\">";
    $card .= "\n\t<h3>Add<br>to<br>Progress</h3>";
    $card .= "\n</div>";
    
    $progress = $card . $progress;
    
    $today = date("Y-m-d"); 
    
    $form .= "\n\t<form id=\"new-form\" class=\"progress-form\">";
    $form .= "\n\t\t\t<h2>Add to Progress</h2>";
    $form .= "\n\t\t\t<label>Qs:</label>";
    $form .= "\n\t\t\t<input type=\"number\" name=\"qs\" min=\"1\" required>";
    $form .= "\n\t\t\t<label>Date:</label>";
    $form .= "\n\t\t\t<input type=\"date\" name=\"date\" value=\"$today\" required>";
    $form .= "\n\t\t\t<label>Notes:</label>";
    $form .= "\n\t\t\t<textarea name=\"notes\" form=\"new-form\" placeholder=\"Enter notes here...\"></textarea>";
    $form .= "\n\t\t<input type=\"hidden\" name=\"project-id\" value=\"$projectId\">";
    $form .= "\n\t\t<input type=\"button\" value=\"Add\" onClick=\"formSubmit(this)\">";
    $form .= "\n\t</form>";
    
    
    $today = time();
    $difference = strtotime($dueDate) - $today;
    if ($difference < 0) { $difference = 0; }
    $difference = floor($difference/60/60/24);
    $qsPerDay = round(($qsLeft/$difference),1);
    
    
    $goal = "";
    
    $goal .= "\n<p>Qs Left: <strong>$qsLeft</strong></p>";
    $goal .= "\n<p>There are <strong>$difference</strong> days remaining</p>";
    $goal .= "\n<p>Qs to complete per day: <strong>$qsPerDay</strong></p>";
    
    $settings = "";
    
    $card = "";
    
    $card .= "\n<div class=\"card\" id=\"total\" onClick=\"showForm(this)\">";
    $card .= "\n\t<p>Total Qs:</p>";
    $card .= "\n\t<h3>$total</h3>";
    $card .= "\n</div>";
    
    $settings = $card . $settings;
    
    $form .= "\n\t<form id=\"total-form\" class=\"settings-form\">";
    $form .= "\n\t\t\t<h2>Total Questions</h2>";
    $form .= "\n\t\t\t<label>Qs:</label>";
    $form .= "\n\t\t\t<input type=\"number\" value=\"$total\" name=\"argument\" min=\"1\" required>";
    $form .= "\n\t\t\t<input type=\"hidden\" value=\"total\" name=\"parameter\" required>";
    $form .= "\n\t\t<input type=\"button\" value=\"Update\" onClick=\"formSubmit(this)\">";
    $form .= "\n\t</form>";
    
    $dateObj =date_create($dueDate);
    $dateFormatted = date_format($dateObj,"d/m/Y");
    
    $card = "";
    
    $card .= "\n<div class=\"card\" id=\"dueDate\" onClick=\"showForm(this)\">";
    $card .= "\n\t<p>Due Date:</p>";
    $card .= "\n\t<h3>$dateFormatted</h3>";
    $card .= "\n</div>";
    
    $settings = $card . $settings;
    
    $form .= "\n\t<form id=\"dueDate-form\" class=\"settings-form\">";
    $form .= "\n\t\t\t<h2>Total Questions</h2>";
    $form .= "\n\t\t\t<label>Qs:</label>";
    $form .= "\n\t\t\t<input type=\"date\" value=\"$dueDate\" name=\"argument\" min=\"1\" required>";
    $form .= "\n\t\t\t<input type=\"hidden\" value=\"dueDate\" name=\"parameter\" required>";
    $form .= "\n\t\t<input type=\"button\" value=\"Update\" onClick=\"formSubmit(this)\">";
    $form .= "\n\t</form>";
    
    
    addElementToChange("#modal-progress-form", $form);
    addElementToChange("#progress-inside", $progress);
    addElementToChange("#goal-inside", $goal);
    addElementToChange("#settings-inside", $settings);
    
    sendJSON();


?> 


