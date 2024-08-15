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


    $TotalAlcoholconsumed = $Alcoholperdrink * $Drinks_no;

    if ($Weightunit == "kg") {
        $Weight = 2.20462 * $Weight;
    }


    if ($Gender == "male") {
        $BAC =  (($TotalAlcoholconsumed * 5.14) / ($Weight * Mcons)) - (0.015 * $Timelapsed);
    } else {

        $BAC = (($TotalAlcoholconsumed * 5.14) / ($Weight * Fcons)) - (0.015 * $Timelapsed);
    }

    $result = $BAC < 0.08 ? "Safe to drive" : "Not safe to drive";

    echo "Blood concentration is " . number_format($BAC, 2) . " and its " . $result;

    die();
}
