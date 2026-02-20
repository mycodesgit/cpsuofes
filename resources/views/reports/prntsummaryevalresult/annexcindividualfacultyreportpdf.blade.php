<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>INDIVIDUAL FACULTY EVALUATION REPORT</title>
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
			<span class="colon">:</span> {{ $facultySemester }} / {{ request('schlyear') }}
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

    <div style="margin-top: 20px; margin-left: -9px;">
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
                @foreach ($facrated as $facrateditem)
                    <tr>
                        <td style="text-align: center">{{ $loop->iteration }}</td>
                        <td style="text-align: left">{{ $facrateditem->sub_name ?? 'N/A' }}</td>
                        <td style="text-align: center">{{ $facrateditem->subSec ?? 'N/A' }}</td>
                        <td style="text-align: center">{{ $facrateditem->noofstudents ?? 0, 2 }}</td>
                        <td style="text-align: center">{{ number_format($facrateditem->avgsetrating, 2) ?? 0 }}</td>
                        <td style="text-align: center">{{ number_format($facrateditem->weightedsetscore, 2) ?? 0 }}</td>
                    </tr>
                @endforeach
				<tr>
					<td colspan="3" style="text-align: right; font-weight: bold;">TOTAL</td>
					<td style="text-align: center">{{ $facrated->sum('noofstudents') ?? 0 }}</td>
					<td style="text-align: center; font-weight: bold;">TOTAL</td>
					<td style="text-align: center">{{ number_format($facrated->sum('weightedsetscore'), 2) ?? 0 }}</td>
				</tr>
            </tbody>
        </table>
    </div>

    <div style="margin-top: 30px; font-weight: bold">
		<p>C. SET and SEF Ratings</p>
	</div>
    <div style="
        text-align: justify;
        padding-left: 120px;
        text-indent: -120px;
        line-height: 1.6;
    ">
        <span style="font-weight:bold;">Computation:</span>
        Calculate the Overall SET Rating by dividing the total Weighted SET Score
        by the total number of students. In the example above, the total weighted
        value is {{ number_format($facrated->sum('weightedsetscore'), 2) ?? 0 }} while the total number of students is {{ $facrated->sum('noofstudents') ?? 0 }}. Therefore,
        {{ number_format($facrated->sum('weightedsetscore'), 2) ?? 0 }} ÷ {{ $facrated->sum('noofstudents') ?? 0 }} = {{ number_format($overallSetRating ?? 0, 2) }}.
    </div>

    <div style="margin-left: -9px; margin-left: -9px;">
        <table id="table">
            <thead>
                <tr>
                    <th></th>
                    <th>SET Rating</th>
                    <th>*SEF Rating</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="text-align: left; font-weight: bold;">OVERALL RATING</td>
                    <td style="text-align: center">{{ number_format($overallSetRating ?? 0, 2) }}</td>
                    <td style="text-align: center">{{ number_format($overallSefRating ?? 0, 2) }}</td>
                </tr>
            </tbody>
        </table>
		<p style="font-style: italic; font-size: 9pt; margin-left: 10px; margin-top: -5px !important">Note: rating given by the supervisor using the SEF instrument</p>
    </div>
	
	<div style="margin-top: 30px; font-weight: bold">
		<p>D. Summary of Qualitative Comments and Suggestions</p>
	</div>

	<div style="margin-top: -30px; margin-left: -9px;">
		<table id="table">
            <thead>
                <tr>
                    <th>Seq</th>
                    <th>Comments and Suggestions from the Students</th>
                </tr>
            </thead>
            <tbody>
				@foreach ($evaluationsStudent as $evaluationsStudentitem)
					<tr>
						<td style="text-align: center;">{{ $evaluationsStudentitem->ratecount }}</td>
						<td style="text-align: center">{{ $evaluationsStudentitem->qcecomments ?? '' }}</td>
					</tr>
				@endforeach
            </tbody>
        </table>
	</div>

	<div style="margin-top: -5px; margin-left: -9px;">
		<table id="table">
            <thead>
                <tr>
                    <th>Seq</th>
                    <th>Comments and Suggestions from the Supervisor</th>
                </tr>
            </thead>
            <tbody>
				@foreach ($evaluationsSupervisor as $evaluationsSupervisoritem)
					<tr>
						<td style="text-align: center;">{{ $loop->iteration }}</td>
						<td style="text-align: center">{{ $evaluationsSupervisoritem->qcecomments ?? '' }}</td>
					</tr>
				@endforeach
            </tbody>
        </table>
	</div>

	<div  style="margin-top: 30px">
		<p>Prepared by:</p>
	</div>
	<div class="details" style="margin-top: 10px; margin-left: 25px;">
        <span style="display: inline-block; width: 230px; vertical-align: top; font-weight: bold;">Signature of Staff</span>
        <div style="display: inline-block; margin-left: 20px; vertical-align: top; text-align: left; border-bottom: 1px solid black; width: 250px;">
            :
        </div>
    </div>
	<div class="details" style="margin-top: 30px; margin-left: 25px;">
        <span style="display: inline-block; width: 230px; vertical-align: top; font-weight: bold;">Name of Staff</span>
        <div style="display: inline-block; margin-left: 20px; vertical-align: top; text-align: left; border-bottom: 1px solid black; width: 250px;">
            :
        </div>
    </div>
	<div class="details" style="margin-top: 30px; margin-left: 25px;">
        <span style="display: inline-block; width: 230px; vertical-align: top; font-weight: bold;">Date</span>
        <div style="display: inline-block; margin-left: 20px; vertical-align: top; text-align: left; border-bottom: 1px solid black; width: 250px;">
            : {{ date('F d, Y') }}
        </div>
    </div>

	<div  style="margin-top: 10px">
		<p>Reviewed by:</p>
	</div>
	<div class="details" style="margin-top: 10px; margin-left: 25px;">
        <span style="display: inline-block; width: 230px; vertical-align: top; font-weight: bold;">Signature of Authorized Official</span>
        <div style="display: inline-block; margin-left: 20px; vertical-align: top; text-align: left; border-bottom: 1px solid black; width: 250px;">
            :
        </div>
    </div>
	<div class="details" style="margin-top: 30px; margin-left: 25px;">
        <span style="display: inline-block; width: 230px; vertical-align: top; font-weight: bold;">Name of Authorized Official</span>
        <div style="display: inline-block; margin-left: 20px; vertical-align: top; text-align: left; border-bottom: 1px solid black; width: 250px;">
            :
        </div>
    </div>
	<div class="details" style="margin-top: 30px; margin-left: 25px;">
        <span style="display: inline-block; width: 230px; vertical-align: top; font-weight: bold;">Date</span>
        <div style="display: inline-block; margin-left: 20px; vertical-align: top; text-align: left; border-bottom: 1px solid black; width: 250px;">
            : {{ date('F d, Y') }}
        </div>
    </div>

</body>
</html>