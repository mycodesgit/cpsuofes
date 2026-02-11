@extends('layout.app')

@section('body')
    <div class="row ">
        <div class="col-md-12">
            <div class="mb-6">
                <h1 class="fs-3 mb-4">Setting</h1>
                <div class="row">
                    <div class="col-md-12">
                        <form method="post" action="{{ route('toggleEval') }}" id="">
                            @csrf

                            <div class="alert alert-secondary alert-dismissible">
                                <div class="form-group mt-3">
                                    <div class="form-row">
                                        <div class="col-8">
                                            <div class="icheck-success">
                                                <input type="checkbox" id="evalset" name="statuseval"
                                                    data-url="{{ route('toggleEval') }}"
                                                    {{ $setevalmode->statuseval === 'On' ? 'checked' : '' }}
                                                    style="width: 20px; height: 20px; cursor: pointer;">
                                                <label for="evalset">
                                                    <h3 style="margin-top: -5px">Faculty Evaluation Status</h3>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <h5><i class="icon fas fa-exclamation-triangle text-warning"></i> Note!</h5>
                                <span class="text-dark text-bold">Check the checkbox if you want start Faculty
                                    Evaluation</span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('evalset').addEventListener('change', function () {
            let isChecked = this.checked;
            let url = this.dataset.url;

            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name=_token]').value
                },
                body: JSON.stringify({ statuseval: isChecked })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    //alert(data.message); // Optional: Show a confirmation alert
                    Swal.fire({
                        icon: 'success',
                        title: 'Online Faculty Evaluation System',
                        text: data.message,
                    });
                } else {
                    Swal.fire({
                        icon: 'warning',
                        text: 'An error occurred!',
                    });
                }
            })
            .catch(error => console.error('Error:', error));
        });

        
    </script>
@endsection
