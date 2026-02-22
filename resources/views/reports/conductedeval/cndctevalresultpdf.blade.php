<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Faculty Load</title>

	<style>
		.tablehead{
			border: none !important;
		}
	    table {
	        width: 100%;
	        border-collapse: collapse;
	        font-size: 10pt;
	    }
	    th {
	        border: 1px solid black;
	        text-align: center;
	        padding: 8px;
	    }
	    td {
	        border: 1px solid black;
	        text-align: left;
	        padding: 8px;
	    }
		.studinfolabel {
            text-align: left;
            font-size: 12pt;
            font-family: sans-serif;
            margin-top: 25px;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }
        .info-label, .info-data {
            margin-right: 0px;
        }
        .info-label {
            font-weight: normal;
        }
        .info-data {
            text-decoration: none;
            font-weight: bold;
        }
	</style>
</head>
<body>
	<div align="center" style="margin-top: -30px">
        <img src="{{ public_path('template/img/allformheader/header-qa.png') }}" width="80%">
    </div>

    <div align="center" style="margin-top: 10px">
        <h3>FACULTY Evaluation Conducted for School Year {{ request('schlyear') }} - 
			@if(request('semester') == 1)
                First Semester
            @elseif(request('semester') == 2)
                Second Semester
            @elseif(request('semester') == 3)
                Summer
            @else
                Unknown Semester
            @endif
        </h3>
    </div>

    <div class="studinfolabel">
	    <div class="info-row">
	        <span class="info-label">Faculty Name:</span>
	        <span class="info-data">{{ $facultyName }}</span>
	    </div>
	</div>

	<div class="studinfolabel">
	    <div class="info-row">
	        <span class="info-data">College: {{ $facloadsched->first()->dept }}</span>
	    </div>
	</div>

	<div>
		<table>
			<thead style="background-color: skyblue">
                <tr>
                    <th>College</th>
                    <th>Subject Name</th>
                    <th>Faculty</th>
                    <th>Subject Section</th>
                    <th>No. of Stud</th>
                    <th>No. of Stud Eval</th>
                    <th>% Eval</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalSublecredit = 0;
                    $totalSublabcredit = 0;
                    $totalSubUnit = 0;
                    $totalStudentCount = 0;
                    $totalStudentEvalCount = 0;
                    $totalStudentEvalPercentCount = 0;
                    $totalOverAllEvalPercentCount = 0;
                @endphp
                @foreach($facloadsched as $datafacloadsched)
                    @if(isset($evalCounts[$datafacloadsched->subject_id]))
                        @php
                            $totalSublecredit += $datafacloadsched->sublecredit;
                            $totalSublabcredit += $datafacloadsched->sublabcredit;
                            $totalSubUnit += $datafacloadsched->sub_unit;
                            $totalStudentCount += $datafacloadsched->studentCount;
                            $totalStudentEvalCount += $evalCounts[$datafacloadsched->subject_id]->eval_count;
                            $totalStudentEvalPercentCount = $evalCounts[$datafacloadsched->subject_id]->eval_count / $datafacloadsched->studentCount * 100;
                            $totalOverAllEvalPercentCount = $totalStudentEvalCount / $totalStudentCount * 100;
                        @endphp
                        <tr>
                            <td>{{ $datafacloadsched->dept }}</td>
                            <td>{{ $datafacloadsched->sub_name }} - {{ $datafacloadsched->sub_title }}</td>
                            <td>{{ $datafacloadsched->lname }}, {{ $datafacloadsched->fname }} {{ substr($datafacloadsched->mname, 0, 2) }}</td>
                            <td>{{ $datafacloadsched->subSec }}</td>
                            <td>{{ $datafacloadsched->studentCount }}</td>
                            <td>{{ $evalCounts[$datafacloadsched->subject_id]->eval_count ?? 0 }}</td>
                            <td>{{ number_format($totalStudentEvalPercentCount, 2) }} %</td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
            <tr>
                <td style="text-align: right; border-bottom: 1px solid black;" colspan="4"><strong>TOTAL:</strong></td>
                <td style="text-align: center; border-bottom: 1px solid black;" width="10%"><strong>{{ $totalStudentCount }}</strong></td>
                <td style="text-align: center; border-bottom: 1px solid black;" width="10%"><strong>{{ $totalStudentEvalCount }}</strong></td>
                <td style="text-align: center; border-bottom: 1px solid black;" width="10%"><strong>{{ number_format($totalOverAllEvalPercentCount, 2) }} %</strong></td>
            </tr>
		</table>
	</div>
</body>
</html>