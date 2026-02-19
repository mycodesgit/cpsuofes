<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>SUPERVISOR'S EVALUATION OF FACULTY</title>
	<style>
		body {
			font-size: 12pt;
			font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", "Noto Sans", "Liberation Sans", Arial,
        		sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
			padding-left: 40px !important;
			padding-right: 40px !important;
		}
		.label {
			display: inline-block;
			width: 290px; /* Adjust width as needed */
		}
		.ratingscale {
			font-weight: bold;
		}
		.ratingscaletd {
			padding: 5px;
		}
		.radio-container {
			margin-top: 5px;
            display: flex;
            align-items: center; /* Aligns the radio button and label */
            gap: 5px; /* Adds some space between the radio button and text */
        }
        #table {
            margin-top: 10px;
            font-family: Arial;
            border-collapse: collapse;
            width: 100%;
            border: 1px solid #000;
        }
        #table td {
        	vertical-align: center !important;
    		text-align: left;
            border: 1px solid #000;
            font-size: 11pt;
			padding: 5px;
			font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", "Noto Sans", "Liberation Sans", Arial,
        	sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji"
        } 
        #table th {
			font-size: 13pt;
            border: 1px solid #000;
            padding: 5px;
			font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", "Noto Sans", "Liberation Sans", Arial,
        	sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji"
        }
        #table-inside {
            margin-top: 10px;
            font-family: Arial;
            border-collapse: collapse;
            width: 100%;
            border: 1px solid #fff;
		}

		#table-inside td, #table-inside th {
		    border: 1px solid #fff;
		}
		#table-inside td {
		    font-family: monospace;
		}
		.form-control {
            border: none;
            border-bottom: 2px solid #ccc;
            border-radius: 0;
            box-shadow: none;
            width: 50%;
            outline: none;
            padding: 5px 0;
        }
        .comment-lines hr {
	        border: none;
	        margin-top: 20px !important;
	        border-top: 1px solid #000;
	        margin: 10px 0;
	        width: 100%;
	    }

	    .comment-lines {
		    margin-top: 5px;
		}

		.line {
		    border-bottom: 1px solid black;
		    height: 20px; /* Adjust the height to match the lines in your image */
		    line-height: 20px;
		    padding-left: 5px;
		}

	</style>
</head>
<body>
	@php
		$underlineLengthName = 23; 
		$underlineLengthRank = 23; 

		$facultyName = $fcs->first()->qcefacname ?? '';
		$academicRank = $facRanck->first()->rank ?? '';
		$facultyProgCode = $fcs->first()->prog ?? '';
		$colleges = [
			'CAF' => 'College of Agriculture and Forestry',
			'CAS' => 'College of Arts and Sciences',
			'CBM' => 'College of Business Management',
			'CCS' => 'College of Computer Studies',
			'CJE' => 'College of Criminal Justice and Education',
			'COE' => 'College of Engineering',
			'CTE' => 'College of Teacher Education',
		];
		$facultyProg = $colleges[$facultyProgCode] ?? '';
		$facultySchlyear = $fcs->first()->schlyear ?? '';
		$facultySemesterCode = $fcs->first()->semester ?? '';
		$semesters = [
			1 => '1st Semester',
			2 => '2nd Semester',
			3 => 'Summer',
		];
		$facultySemester = $semesters[$facultySemesterCode] ?? '';

		$underlineFaculty = str_pad($facultyName, $underlineLengthName, '_', STR_PAD_BOTH);
		$underlineRank = str_pad($academicRank, $underlineLengthRank, '_', STR_PAD_BOTH);
	@endphp

	<div style="margin-top: -30px; text-align: right; font-size: 10pt">
		<p>ANNEX C - Individual Faculty Evaluation Report</p>
	</div>

	<div style="margin-top: 20px; text-align: center; font-weight: bold">
		<p>
			INDIVIDUAL FACULTY EVALUATION REPORT
		</p>
	</div>


	<div style="margin-top: 30px; font-weight: bold">
		<p>A. Faculty Information</p>
	</div>

	<div style="font-weight: normal; padding-left: 20px; margin-top: -20px;">
		<p>
			<span class="label">Name of Faculty Evaluated</span>
			<span class="colon">:</span> {{ $facultyName }}
		</p>
		<p>
			<span class="label">Department/College</span>
			<span class="colon">:</span> {{ $facultyProg }}
		</p>
		<p>
			<span class="label">Current Faculty Rank</span>
			<span class="colon">:</span> {{ $academicRank }}
		</p>
		<p>
			<span class="label">Semester/Term & Academic Year</span>
			<span class="colon">:</span> {{ $facultySemester }}
		</p>
	</div>

	<div style="margin-top: 30px; font-weight: bold">
		<p>B. Summary of Average SET Rating</p>
	</div>

    <div style="margin-top: -20px">
        <p>Computation:</p>
        <div style="margin-left: 30px">
            <span style="font-weight: bold">Step 1:</span> Get the average SET rating for each class. <br>
            <span style="font-weight: bold">Step 2:</span> Multiply the number of students in each class with its average SET rating to &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; get the Weighted SET Score per class. <br>
            <span style="font-weight: bold">Step 3:</span> Get the total number of students and the total weighted SET score. <br>
        </div>
    </div>

    <div style="margin-top: 20px">
        <table id="table">
            <thead>
                <tr>
                    <th>Seq</th>
                    <th>(1) <br> Course Code</th>
                    <th>(2) <br> Year/Section</th>
                    <th>(3) <br> No. of Students</th>
                    <th>(4) <br> Average SET Rating</th> 
                    <th>(3 x 4) <br> Weighted <br> SET Score</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
	
</body>
</html>