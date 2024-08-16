<?php
// BAC = (Alcohol Consumed (grams) * 5.14) / (Weight (lbs) * Gender Constant) - 0.015 * Time Elapsed (hours) Where:

// Alcohol Consumed is the total amount of alcohol consumed in grams.
// Gender Constant is 0.73 for males and 0.66 for females.
//The legal BAC limit for driving is 0.08%. If the calculated BAC exceeds this limit, it is illegal to drive in most jurisdictions.
const Mcons = 0.73;
const Fcons = 0.66;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $Weight = $_POST["weight"];
    $Drinks_no = $_POST["drinks"];
    $Alcoholperdrink = (float) $_POST["alcohol_content"];
    $Timelapsed = $_POST["time_elapsed"];
    $Weightunit = $_POST["unit"];
    $Gender = $_POST["gender"];


    $BAC = Calculate_bac($Gender == "male" ? Mcons : Fcons, $Alcoholperdrink * $Drinks_no, $Weight, $Timelapsed, $Weightunit);

    $result = $BAC < 0.08 ? "Safe to drive" : "Not safe to drive";

    header("Location: index.php?bac_result=" . number_format($BAC, 2) . "&status=" . urlencode($result));
    die();
}

function Calculate_bac($cons, $Alcoholconsumed, $weight, $time, $unit)
{
    if ($unit == "kg") {
        $weight = 2.20462 * $weight;
    }
    return (($Alcoholconsumed * 5.14) / ($weight * $cons)) - (0.015 * $time);
}
