<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">	
    @php
        $title = 'SUMMARY SHEET FOR TEACHING EFFECTIVENESS BY EVALUATION TYPE';
        $title2 = 'EVALUATION FORM - STUDENTS';
        $fac_name = $fcs->qcefacname; 
        $rate_period = $fcs->ratingfromto;
        $sem_range = $fcs->semester == 1 ? '1st SEMESTER' : ($fcs->semester == 2 ? '2nd SEMESTER' : 'UNKNOWN SEMESTER');

        $recorder = 'MARY GRACE NOREEN P. LEDUNA-JARANILLA, Ph. D.';
        $recorder_pos = 'Recorder Position';
        $recorder_date = \Carbon\Carbon::now()->format('F d, Y');

        $endorser = 'FERNANDO D. ABELLO, Ph. D.';
        $endorser_pos  = 'Vice President for Academic Affairs';

        $reviewer = $facDesignateId->fname . ' ' . substr($facDesignateId->mname, 0, 1) . ' ' . $facDesignateId->lname . ', ' . $facDesignateId->rankcomma;
        $reviewer_pos  =  $facDesignateId->designation . ', ' . $facDesignateId->college_name = str_replace(' Of ', ' of ', ucwords(strtolower($facDesignateId->college_name)));
        $reviewer_date = \Carbon\Carbon::now()->format('F d, Y');

    @endphp
	<title>{{ $title2 }}</title>
	<style>
		body {
			font-family: Arial, sans-serif !important;
		}
		.title {
			font-weight: bold;
			font-size: 12pt;
		}
		.details {			
			margin-left: 20px;
			text-align: left;
			font-size: 11pt;
		}
        .details-sm {			
			margin-left: 20px;
			text-align: left;
			font-size: 9pt;
		}
		.table {
			margin-top: 20px;
			font-size: 11pt;
		}
        td {
            font-size: 10pt;
        }
		.footer {
		    position: fixed; /* Change to absolute if needed */
		    bottom: 0;
		}
	</style>
</head>
<body>   
    <div>        
        <center class=title>{{ $title }}</center>
    </div>

    <div class="details" style="margin-top: 20px; margin-left: 20px;">
        <span style="display: inline-block; width: 75px; vertical-align: top;">Name:</span>
        <div style="display: inline-block; margin-left: 10px; vertical-align: top; text-align: center; border-bottom: 1px solid black; width: 205px;">
            <span style="font-weight: bold">{{ $fac_name }}</span>
        </div>
    </div>

    <div class="details" style="float: right; margin-top: -20px; margin-right: 20px;">
        <span style="display: inline-block; width: 75px; vertical-align: top; white-space: nowrap;">Rating Period:</span>
        <div style="display: inline-block; margin-left: 20px; vertical-align: top; text-align: center; border-bottom: 1px solid black; width: 205px;">
            <span style="font-weight: bold">{{ $rate_period }}</span>
        </div>  
        <div style="display: block; margin-left: 100px; margin-top: 5px; vertical-align: top; text-align: center; border-bottom: 1px solid black; width: 205px;">
            <span style="font-weight: bold">{{ $sem_range }}</span>
        </div>        
    </div>

	<div id="table1" class="table">
        <table border="1" width="94%" style="border-collapse: collapse; text-align:center; margin-top: 40px; margin-left: 20px; margin-right: 20px;">
            @php
                $overallTotal = 0;
            @endphp
            <tr>
                <th>No. of Student</th>
                <th>Commitment</th>
                <th>Knowledge of Subject</th>
                <th>Teaching for Independent Learning</th>
                <th>Management of Learning</th>
                <th>TOTAL</th>
            </tr>
        
            @foreach($students as $student)
            @php
                $commitment = $student['Commitment'] / 20;
                $knowledge = $student['Knowledge of Subject'] / 20;
                $independent = $student['Teaching for Independent Learning'] / 20;
                $management = $student['Management of Learning'] / 20;
                $total = $commitment + $knowledge + $independent + $management;

                $overallTotal += $total; // Move this line inside the loop

                $total_students = count($students);
            @endphp
            <tr>
                <td>{{ $student['id'] }}</td>
                <td>{{ $student['Commitment'] }}</td>
                <td>{{ $student['Knowledge of Subject'] }}</td>
                <td>{{ $student['Teaching for Independent Learning'] }}</td>
                <td>{{ $student['Management of Learning'] }}</td>
                <td>{{ number_format($total, 2) }}</td>
            </tr>
            @endforeach
        
            <!-- TOTAL Row -->
            <tr>
                <td style="text-align:right; font-weight:bold;">TOTAL</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>{{ number_format($overallTotal / $total_students, 2) }}</td>
            </tr>
        
            <!-- SUPERVISOR Row -->
            <tr>
                <td style="text-align:center; font-weight:bold;">SUPERVISOR</td>
                <td>{{ $supervisor['Commitment'] }}</td>
                <td>{{ $supervisor['Knowledge of Subject'] }}</td>
                <td>{{ $supervisor['Teaching for Independent Learning'] }}</td>
                <td>{{ $supervisor['Management of Learning'] }}</td>
                <td>{{ $supervisor['TOTAL'] }}</td>
            </tr>
        </table>
	</div>    

    <div class="details-sm" style="margin-top: 30px;">
        <span style="display: inline-block; width: 80px; vertical-align: top;">Recorded by:</span>
        <div style="display: inline-block; margin-left: 5px; vertical-align: top; text-align: center; border-bottom: 1px solid black; width: 205px; font-size: 9pt !important">
            <span style="font-weight: bold; font-size: 9pt !important">{{ $recorder }}</span>
        </div>
    </div>

    <div class="details-sm" style="margin-top: 5px;">
        <span style="display: inline-block; width: 80px; vertical-align: top;">Position:</span>
        <div style="display: inline-block; margin-left: 5px; vertical-align: top; text-align: center; border-bottom: 1px solid black; width: 205px;">
            <span>{{ $recorder_pos }}</span>
        </div>
    </div>

    <div class="details-sm" style="margin-top: 5px;">
        <span style="display: inline-block; width: 80px; vertical-align: top;">Date:</span>
        <div style="display: inline-block; margin-left: 5px; vertical-align: top; text-align: center; border-bottom: 1px solid black; width: 205px;">
            <span>{{ $recorder_date }}</span>
        </div>
    </div>

    <div class="details-sm" style="margin-top: 30px;">
        <span style="display: inline-block; width: 80px; vertical-align: top;">Endorsed by:</span>
        <div style="display: inline-block; margin-left: 5px; vertical-align: top; text-align: center; border-bottom: 1px solid black; width: 205px;">
            <span style="font-weight: bold">{{ $endorser }}</span>
        </div>
    </div>

    <div class="details-sm" style="margin-top: 5px;">
        <span style="display: inline-block; width: 80px; vertical-align: top;">Position:</span>
        <div style="display: inline-block; margin-left: 5px; vertical-align: top; text-align: center; border-bottom: 1px solid black; width: 210px;">
            <span>{{ $endorser_pos }}</span>
        </div>
    </div>

    <div class="details-sm" style="margin-top: 30px;">
        <span style="display: inline-block; width: 80px; vertical-align: top;">Conforme:</span>
        <div style="display: inline-block; margin-left: 5px; vertical-align: top; text-align: center; border-bottom: 1px solid black; width: 205px;">
            <span style="font-weight: bold;">{{ $fac_name }}</span>
        </div>
         <div style="text-align: center; width: 205px; margin-left: 88px;">
            <span>Signature of Ratee</span>
        </div>
    </div>    
	
    <div style="float: right; margin-top: -183px; margin-right: 23px;">
    <div class="details-sm">
        <span style="display: inline-block; width: 165px; vertical-align: top; margin-left: -45px;">Reviewed and Discussed with:</span>
        <div style="display: inline-block;  vertical-align: top; text-align: center; border-bottom: 1px solid black; width: 205px;">
            <span style="font-weight: bold">{{ $reviewer }}</span>
        </div>
    </div>

    <div class="details-sm" style="margin-top: 5px;">
        <span style="display: inline-block; width: 165px; vertical-align: top; margin-left: -45px;">Position:</span>
        <div style="display: inline-block; vertical-align: top; text-align: center; border-bottom: 1px solid black; width: 205px;">
            <span>{{ $reviewer_pos }}</span>
        </div>
    </div>

    <div class="details-sm" style="margin-top: 5px;">
        <span style="display: inline-block; width: 165px; vertical-align: top; margin-left: -45px;">Date:</span>
        <div style="display: inline-block; vertical-align: top; text-align: center; border-bottom: 1px solid black; width: 205px;">
            <span>{{ $reviewer_date }}</span>
        </div>
    </div>
    </div>

    <div class="footer">
        {{-- <center><img src="{{ public_path('img/footer.png') }}" width="55%" style="text-align: center !important;"></center> --}}
    </div>
</body>
</html>