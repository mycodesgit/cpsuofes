<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>FACULTY EVALUATION AND DEVELOPMENT ACKNOLWEDGEMENT FORM</title>
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
            padding: 10px;
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
		.details {			
			margin-left: 20px;
			text-align: left;
			font-size: 11pt;
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
		<p>ANNEX D - Faculty Evaluation and Development Acknowledgement Form</p>
	</div>

	<div style="margin-top: 20px; text-align: center; font-weight: bold">
		<p>
			FACULTY EVALUATION AND DEVELOPMENT ACKNOLWEDGEMENT FORM
		</p>
	</div>


	<div style="margin-top: 30px; font-weight: bold">
		<p>A. FACULTY MEMBER INFORMATION</p>
	</div>
	<div style="font-weight: normal; padding-left: 20px; margin-top: -20px;">
		<p>
			<span class="label">Name of Faculty</span>
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
			<span class="colon">:</span> {{ $facultySemester }} / {{ request('schlyear') }}
		</p>
	</div>

	<div style="margin-top: 30px; font-weight: bold">
		<p>B. FACULTY EVALUATION SUMMARY</p>
	</div>
	<div style="margin-top: -30px; margin-left: -10px;">
		<table id="table">
            <thead>
				<tr>
					<th colspan="2" style="font-weight: bold">Overall Rating</th>
				</tr>
                <tr>
                    <th style="font-size: 10pt; background-color:#e4f0f5">Student Evaluation of Teachers (SET)</th>
                    <th style="font-size: 10pt; background-color:#e4f0f5">Supervisor's Evaluation of Faculty (SAF)</th>
                </tr>
            </thead>
            <tbody>
					<tr>
						<td style="text-align: center;"></td>
						<td style="text-align: center"></td>
					</tr>
            </tbody>
        </table>
	</div>

	<div style="margin-top: 30px; font-weight: bold">
		<p>C. Development Plan (to be jointly accomplished by the Supervisor and Faculty)</p>
	</div>
	<div style="margin-top: -30px; margin-left: -10px;">
		<table id="table">
            <thead>
				<tr>
					<th style="font-size: 9pt; text-align: left; vertical-align: top; height: 80px; font-weight: normal">Areas for Improvement</th>
				</tr>
                <tr>
                    <th style="font-size: 9pt; text-align: left; vertical-align: top; height: 80px; font-weight: normal">Proposed Learning and Development Activities</th>
                </tr>
                <tr>
                    <th style="font-size: 9pt; text-align: left; vertical-align: top; height: 80px; font-weight: normal">Action Plan</th>
                </tr>
            </thead>
        </table>
	</div>
	
	<div style="font-weight: bold; font-size: 11pt; text-align: justify">
		<p>
			I acknowledge that I have received and reviewed the faculty evaluation conducted for
			the period mentioned above. I understand that my signature below does not
			necessarily indicate agreement with the evaluation but confirms that I have been
			given the opportunity to discuss it with my supervisor.
		</p>
	</div>

	<div style="margin-top: 5px; margin-left: -10px;">
		<table id="table">
            <thead>
				<tr>
					<th colspan="3" style="font-weight: bold; background-color:#e4f0f5">SUPERVISOR</th>
				</tr>
                <tr>
                    <th style="font-size: 10pt; width: 25%; text-align: left">Signature</th>
                    <th style="font-size: 10pt; width: 5%">:</th>
                    <th style="font-size: 10pt;"></th>
                </tr>
				<tr>
                    <th style="font-size: 10pt; width: 25%; text-align: left">Name</th>
                    <th style="font-size: 10pt; width: 5%">:</th>
                    <th style="font-size: 10pt;"></th>
                </tr>
				<tr>
                    <th style="font-size: 10pt; width: 25%; text-align: left">Date Signed</th>
                    <th style="font-size: 10pt; width: 5%">:</th>
                    <th style="font-size: 10pt;"></th>
                </tr>
            </thead>
			<thead>
				<tr>
					<th colspan="3" style="font-weight: bold; background-color:#e4f0f5">FACULTY</th>
				</tr>
                <tr>
                    <th style="font-size: 10pt; width: 25%; text-align: left">Signature</th>
                    <th style="font-size: 10pt; width: 5%">:</th>
                    <th style="font-size: 10pt;"></th>
                </tr>
				<tr>
                    <th style="font-size: 10pt; width: 25%; text-align: left">Name</th>
                    <th style="font-size: 10pt; width: 5%">:</th>
                    <th style="font-size: 10pt;"></th>
                </tr>
				<tr>
                    <th style="font-size: 10pt; width: 25%; text-align: left">Date Signed</th>
                    <th style="font-size: 10pt; width: 5%">:</th>
                    <th style="font-size: 10pt;"></th>
                </tr>
            </thead>
        </table>
	</div>

</body>
</html>