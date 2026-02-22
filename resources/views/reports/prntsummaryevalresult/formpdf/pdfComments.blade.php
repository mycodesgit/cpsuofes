<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	@php
		$fac_name = $facsum->qcefacname ?? ' ';
		$rate_period = $rating_period ?? ' ';		
		$sem_range = request('semester');
		if ($semester == 1) {
            $sem_range = 'First Semester';
        } elseif ($semester == 2) {
            $sem_range = 'Second Semester';
        } elseif ($semester == 3) {
            $sem_range = 'Summer';
        } else {
            $sem_range = '';
        }
		$sch_yr = $facsum->schlyear ?? ' ';	
		$title = 'Comments';
		$title2 = 'FACULTY EVALUATION COMMENTS';
		$drafter = 'MARY GRACE NOREEN P. LEDUNA-JARANILLA, Ph. D.';
		$notary1 = 'ENGR. ROSE ANN G. JOCSON';
		$notary2 = 'GRENNY I. JUNGCO, Ph. D.';
	@endphp
	<title>{{ $title2 }}</title>
	<style>
		@page {
			margin-top: 160px;
			margin-bottom: 140px;
			margin-left: 30px;
			margin-right: 30px;
		}
		body {
			font-family: Arial, sans-serif !important;
		}
		.title {
			margin-top: 10px;
			font-weight: bold;
			font-size: 12pt;
		}
		.details {			
			margin-left: 20px;
			text-align: left;
			font-size: 11pt;
		}

		table {
			page-break-inside: auto;
		}

		tr {
			page-break-inside: avoid;
			page-break-after: auto;
		}

		.table {
			margin-top: 10px;
			font-size: 10pt;
		}
		.header {
			position: fixed;
			top: -140px;
			left: 0;
			right: 0;
			height: 140px;
		}

		.footer {
			position: fixed;
			bottom: -130px;
			left: 0;
			right: 0;
			height: 120px;
		}


		.prepared-block {
			margin-top: 90px; /* This margin now applies under header space */
		}
		.noted-block {
			margin-top: 20px; /* This margin now applies under header space */
		}
	</style>
</head>
<body>
	@if(empty($facsum))
		<div class="header">
			<center><img src="{{ public_path('assets/images/allformheader/header-me.png') }}" width="95%"></center>
		</div>

		<div class="footer">
			<center><img src="{{ public_path('assets/images/allformheader/footer.png') }}" width="95%"></center>
		</div>
		
		<div class="title">
			<center><u><h5>{{ strtoupper($title) }}</h5></u></center>
		</div>

		<!-- EMPTY STATE -->
		<div class="empty-wrapper">
			<h1 style="text-align: center">Records not Found</h1>
			<h3 style="text-align: center">
				No students evaluated this teacher during the selected rating period.
			</h3>
		</div>
	@else
		<div class="header">
			<center><img src="{{ public_path('template/img/allformheader/header-me.png') }}" width="95%"></center>
		</div>

		<div class="footer">
			<center><img src="{{ public_path('template/img/allformheader/footer.png') }}" width="95%"></center>
		</div>

		<div class="details">
			<span style="display: inline-block; width: 120px; vertical-align: top;">Name of Faculty:</span><b style="display: inline-block; vertical-align: top; text-transform: uppercase;">{{ $fac_name }}</b>
		</div>

		<div class="details">
			<span style="display: inline-block; width: 120px; vertical-align: top; font-weight: normal;">Rating Period:</span><b style="display: inline-block; vertical-align: top; font-weight: normal">{{ $rate_period }}</b>
		</div>

		<div class="details">
			<span style="display: inline-block; width: 120px; vertical-align: top; font-weight: normal;"></span><b style="display: inline-block; vertical-align: top; font-weight: normal">{{ $sem_range }}, S.Y. {{ $sch_yr }}</b>
		</div>

		<div class="title">
			<center><h4>{{ $title }}</h4></center>
		</div>

		<b style="font-weight: bold; margin-left: 20px; font-size: 11pt;">Students:</b>

		@php
			$chunks = $studcomments->sortBy('ratecount')->chunk(40);
		@endphp

		{{-- @foreach ($chunks as $chunkIndex => $chunk)
			@if ($chunkIndex > 0)
				<div style="page-break-before: always;"></div>
			@endif

			<b style="font-weight: bold; margin-left: 20px; font-size: 11pt;">&nbsp;</b>

			<div id="table1" class="table">
				<table border="1" width="94%" style="margin-bottom: 20px; margin-left: 20px; margin-right: 20px; border-collapse: collapse;">
					@foreach ($chunk as $datastudcomments)
						<tr>
							<td style="padding-left: 10px;">
								{{ $datastudcomments->ratecount }}. {{ $datastudcomments->qcecomments }}
							</td>
						</tr>
					@endforeach
				</table>
			</div>
		@endforeach --}}

		<div class="table">
			<table border="1" width="94%" style="margin-bottom: 20px; margin-left: 20px; margin-right: 20px; border-collapse: collapse;">
				@foreach ($studcomments->sortBy('ratecount') as $datastudcomments)
					<tr>
						<td style="padding-left: 10px;">
							{{ $datastudcomments->ratecount }}. {{ $datastudcomments->qcecomments }}
						</td>
					</tr>
				@endforeach
			</table>
		</div>

		

		<b style="font-weight: bold; margin-left: 20px; font-size: 11pt;">Supervisor:</b>
		
		<div id="table2" class="table">
			<table border="1" width="94%" style="margin-bottom: 20px; margin-left: 20px; margin-right: 20px; border-collapse: collapse;">	
				@if ($supercomments->isNotEmpty()) 
					@foreach ($supercomments as $datasupercomments)
						<tr>
							<td style="height: 20px; padding-left: 10px;"> 1. {{ $datasupercomments->qcecomments }}</td>
						</tr>
					@endforeach
				@else
					<tr>
						<td style="height: 20px; padding-left: 10px;"> 1. </td>
					</tr>
				@endif
		
			</table>
		</div> 

		<div style="page-break-before: always;"></div>

		<div class="prepared-block" style="text-align: left; margin-left: 25px; margin-right: 20px;">
			<div style="text-align: left; display: inline-block; margin-top: 30px;">
				<div style="margin-bottom: 50px;">Prepared by:<br></div>
				<b>{{ $drafter }}</b><br>
				Monitoring and Evaluation Coordinator
			</div>
		</div>

		<div class="noted-block" style="text-align: left; margin-left: 25px; margin-right: 20px;">
			<div style="text-align: left; display: inline-block; margin-top: 20px;">
			<br><br>Noted:<br><br><br>
				<b>{{ $notary1 }}</b><br>
				Quality Assurance Director<br><br><br><br><br><br>
				<b>{{ $notary2 }}</b><br>
				Vice President for Academic Affairs
			</div>
		</div>
	@endif
	
</body>
</html>