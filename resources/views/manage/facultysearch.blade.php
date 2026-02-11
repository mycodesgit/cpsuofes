@extends('layout.app')

@section('body')
    <div class="row ">
        <div class="col-md-12">
            <div class="mb-6">
                <h1 class="fs-3 mb-4">Faculty</h1>
                <div class="card">
                    <div class="card-body">
                        <div>
                            <table id="facltyTable" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Academic Rank</th>
                                        <th>Email</th>
                                        <th>College</th>
                                        <th>Campus</th>
                                        <th>Image</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="uploadfacPhotoModal" role="dialog" aria-labelledby="uploadfacPhotoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editFundModalLabel">Upload Photo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="uploadfacPhotoForm" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input type="hidden" name="facidprof" id="uploadfacPhotoId" readonly>
                        <div class="row">
                            <div class="col-md-3">
                                <label for="editLastname">Lastname</label>
                                <input type="text" class="form-control form-control-sm" id="editLastname" name="lname" oninput="var words = this.value.split(' '); for(var i = 0; i < words.length; i++){ words[i] = words[i].substr(0,1).toUpperCase() + words[i].substr(1); } this.value = words.join(' ');" readonly>
                            </div>
                            <div class="col-md-3">
                                <label for="editFirstname">Firstname</label>
                                <input type="text" class="form-control form-control-sm" id="editFirstname" name="fname" oninput="var words = this.value.split(' '); for(var i = 0; i < words.length; i++){ words[i] = words[i].substr(0,1).toUpperCase() + words[i].substr(1); } this.value = words.join(' ');" readonly>
                            </div>
                            <div class="col-md-3">
                                <label for="editMiddlename">Middlename</label>
                                <input type="text" class="form-control form-control-sm" id="editMiddlename" name="mname" oninput="var words = this.value.split(' '); for(var i = 0; i < words.length; i++){ words[i] = words[i].substr(0,1).toUpperCase() + words[i].substr(1); } this.value = words.join(' ');" readonly>
                            </div>
                            <div class="col-md-3">
                                <label for="editExtname">Ext</label>
                                <input type="number" class="form-control form-control-sm" id="editExtname" name="ext" readonly>
                            </div>

                            <div class="col-md-6 mt-4">
                                <label for="editImage" class="font-weight-bold">Upload Photo</label>
                                <div id="dropZone" class="file-drop-zone" 
                                    style="border: 2px dashed #47b656; border-radius: 10px; padding: 40px; text-align: center; cursor: pointer; position: relative;">
                                    <input type="file" class="custom-file-input" id="editImage" name="profimage" accept=".png, .jpg" 
                                        onchange="previewImage(event)" style="opacity: 0; position: absolute; top: 0; left: 0; width: 100%; height: 100%; cursor: pointer;">
                                    <div class="file-upload-content">
                                        <div class="upload-icon" style="font-size: 3em; color: #47b656;">
                                            <i class="fas fa-cloud-upload-alt"></i>
                                        </div>
                                        <p class="upload-text" style="margin: 10px 0; color: #47b656;">Browse Files to upload</p>
                                    </div>
                                </div>
                                <div class="file-info mt-2" style="text-align: center; color: #555;">
                                    <i class="fas fa-file"></i> <span id="fileNameDisplay">No selected file -</span>
                                    <button type="button" class="btn btn-sm btn-warning btn-sm" onclick="clearFile()">
                                        Cancel
                                    </button>
                                </div>
                            </div>
                                    
                            <div class="col-md-6 mt-4">
                                <div class="form-group">
                                    <label for="imagePreview" class="font-weight-bold">Photo Preview</label>
                                    <div class="image-preview-container" style="position: relative; width: 100%; height: 200px; border: 1px solid #ddd; border-radius: 5px; overflow: hidden;">
                                        <img id="imagePreview" src="#" alt="Image Preview" style="display: none; width: 100%; height: 100%; object-fit: cover;"/>
                                        <div class="image-preview-overlay" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 1.2em;">
                                            No Photo
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-warning" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-outline-success">Yes, upload photo</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="viewUploadedPhotoModal" role="dialog" aria-labelledby="viewUploadedPhotoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewUploadedPhotoModalLabel">Uploaded Photo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="viewUploadedPhotoId">
                        <div class="form-group">
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th style="text-align: left; font-size: 13pt;"><i></i>
                                            <p id="fullName" class="font-weight-bold" style="font-size: 16px; text-align: center;"></p>
                                        </th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="form-group" style="text-align: center">
                            <input type="hidden" id="viewUploadedPhoto" class="form-control form-control-sm" >
                            <img id="uploadedPhoto" class="img-cirle" width="50%" src="" alt="Image">

                            <div class="image-preview-container" id="noPhoto" style="position: relative; width: 100%; height: 200px; border: 1px solid #ddd; border-radius: 5px; overflow: hidden;">
                                <img id="imagePreview" src="#" alt="Image Preview" style="display: none; width: 100%; height: 100%; object-fit: cover;"/>
                                <div class="image-preview-overlay" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 1.2em;">
                                    <p style="text-align: center;" class="big-text">No Photo</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-info" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="updatefacPhotoModal" role="dialog" aria-labelledby="updatefacPhotoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updatefacPhotoModalLabel">Update Photo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="updatefacPhotoForm" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input type="hidden" name="facidprof" id="updatefacnewPhotoId" readonly>

                        <div class="row">
                            <div class="col-md-3">
                                <label for="editnewLastname">Lastname</label>
                                <input type="text" class="form-control form-control-sm" id="editnewLastname" name="lname" oninput="var words = this.value.split(' '); for(var i = 0; i < words.length; i++){ words[i] = words[i].substr(0,1).toUpperCase() + words[i].substr(1); } this.value = words.join(' ');" readonly>
                            </div>
                            <div class="col-md-3">
                                <label for="editnewFirstname">Firstname</label>
                                <input type="text" class="form-control form-control-sm" id="editnewFirstname" name="fname" oninput="var words = this.value.split(' '); for(var i = 0; i < words.length; i++){ words[i] = words[i].substr(0,1).toUpperCase() + words[i].substr(1); } this.value = words.join(' ');" readonly>
                            </div>
                            <div class="col-md-3">
                                <label for="editnewMiddlename">Middlename</label>
                                <input type="text" class="form-control form-control-sm" id="editnewMiddlename" name="mname" oninput="var words = this.value.split(' '); for(var i = 0; i < words.length; i++){ words[i] = words[i].substr(0,1).toUpperCase() + words[i].substr(1); } this.value = words.join(' ');" readonly>
                            </div>
                            <div class="col-md-3">
                                <label for="editnewExtname">Ext</label>
                                <input type="number" class="form-control form-control-sm" id="editnewExtname" name="ext" readonly>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="editImage" class="font-weight-bold">Upload Photo</label>
                                    <div id="dropZone" class="file-drop-zone" 
                                        style="border: 2px dashed #47b656; border-radius: 10px; padding: 40px; text-align: center; cursor: pointer; position: relative;">
                                        <input type="file" class="custom-file-input" id="editImage" name="profimage" accept=".png, .jpg" 
                                            onchange="previewImage(event)" style="opacity: 0; position: absolute; top: 0; left: 0; width: 100%; height: 100%; cursor: pointer;">
                                        <div class="file-upload-content">
                                            <div class="upload-icon" style="font-size: 3em; color: #47b656;">
                                                <i class="fas fa-cloud-upload-alt"></i>
                                            </div>
                                            <p class="upload-text" style="margin: 10px 0; color: #47b656;">Browse Files to upload</p>
                                        </div>
                                    </div>
                                    <div class="file-info mt-2" style="text-align: center; color: #555;">
                                        <i class="fas fa-file"></i> <span id="fileNameDisplay">No selected file -</span>
                                        <button type="button" class="btn btn-sm btn-outline-danger btn-sm ml-2" onclick="clearFile()">
                                            Cancel
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="imagePreview" class="font-weight-bold">Photo Preview</label>
                                    <div class="image-preview-container" style="position: relative; width: 100%; height: 200px; border: 1px solid #ddd; border-radius: 5px; overflow: hidden;">
                                        <img id="imagePreview" src="#" alt="Image Preview" style="display: none; width: 100%; height: 100%; object-fit: cover;"/>
                                        <div class="image-preview-overlay" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 1.2em;">
                                            No Photo
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-info" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-outline-success">Yes, upload photo</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editFacultyModal" role="dialog" aria-labelledby="editFacultyModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editFundModalLabel">Edit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editFacultyForm">
                    <div class="modal-body">
                        <input type="hidden" name="id" id="eeditFacultyId">
                        <div class="form-group">
                            <label for="eeditLastname">Lastname</label>
                            <input type="text" class="form-control form-control-sm" id="eeditLastname" name="lname" oninput="var words = this.value.split(' '); for(var i = 0; i < words.length; i++){ words[i] = words[i].substr(0,1).toUpperCase() + words[i].substr(1); } this.value = words.join(' ');" readonly>
                        </div>
                        <div class="form-group mt-3">
                            <label for="eeditFirstname">Firstname</label>
                            <input type="text" class="form-control form-control-sm" id="eeditFirstname" name="fname" oninput="var words = this.value.split(' '); for(var i = 0; i < words.length; i++){ words[i] = words[i].substr(0,1).toUpperCase() + words[i].substr(1); } this.value = words.join(' ');" readonly>
                        </div>
                        <div class="form-group mt-3">
                            <label for="eeditMiddlename">Middlename</label>
                            <input type="text" class="form-control form-control-sm" id="eeditMiddlename" name="mname" oninput="var words = this.value.split(' '); for(var i = 0; i < words.length; i++){ words[i] = words[i].substr(0,1).toUpperCase() + words[i].substr(1); } this.value = words.join(' ');" readonly>
                        </div>
                        <div class="form-group mt-3">
                            <label for="eeditExtname">Ext</label>
                            <input type="number" class="form-control form-control-sm" id="eeditExtname" name="ext" readonly>
                        </div>
                        <div class="form-group mt-3">
                            <label for="eeditacadrank">Academic Rank</label>
                            <select name="rank" id="eeditacadrank" class="form-control form-control-sm">
                                <option disabled selected> --Select Rank-- </option>
                                <option value=""> --None-- </option>
                                <option value="Professor VI">Professor VI</option>
                                <option value="Professor V">Professor V</option>
                                <option value="Professor IV">Professor IV</option>
                                <option value="Professor III">Professor III</option>
                                <option value="Professor II">Professor II</option>
                                <option value="Professor I">Professor I</option>
                                <option value="Associate Professor V">Associate Professor V</option>
                                <option value="Associate Professor IV">Associate Professor IV</option>
                                <option value="Associate Professor III">Associate Professor III</option>
                                <option value="Associate Professor II">Associate Professor II</option>
                                <option value="Associate Professor I">Associate Professor I</option>
                                <option value="Assistant Professor IV">Assistant Professor IV</option>
                                <option value="Assistant Professor III">Assistant Professor III</option>
                                <option value="Assistant Professor II">Assistant Professor II</option>
                                <option value="Assistant Professor I">Assistant Professor I</option>
                                <option value="Instructor III">Instructor III</option>
                                <option value="Instructor II">Instructor II</option>
                                <option value="Instructor I">Instructor I</option>
                                <option value="Part-Time">Part-Time</option>
                            </select>                        
                        </div>
                        <div class="form-group mt-3">
                            <label for="eeditEmail">Email</label>
                            <input type="email" class="form-control form-control-sm" id="eeditEmail" name="email">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-info" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-outline-success">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        var facultyReadRoute = "{{ route('getfacultylistRead') }}";
        var facultyUploadRoute = "{{ route('facultyUploadImage') }}";
        var photoStorage = "{{ asset('storage/') }}";
        var photoStoragedef = "{{ asset('template/img/user.png') }}";

        var facultyrankUpdateRoute = "{{ route('facultyrankUpdate', ['id' => ':id']) }}";
    </script>

    <script>
        // Preview image when file is selected
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function () {
                const output = document.getElementById('imagePreview');
                const overlay = document.querySelector('.image-preview-overlay');
                output.src = reader.result;
                output.style.display = 'block';
                overlay.style.display = 'none';

                const fileName = event.target.files[0].name;
                document.getElementById('fileNameDisplay').innerText = fileName;
            };
            if (event.target.files.length > 0) {
                reader.readAsDataURL(event.target.files[0]);
            }
        }

        // Clear the selected file
        function clearFile() {
            document.getElementById('editImage').value = '';
            document.getElementById('imagePreview').style.display = 'none';
            document.querySelector('.image-preview-overlay').style.display = 'flex';
            document.getElementById('fileNameDisplay').innerText = 'No selected file -';
        }

        // Drag and Drop functionality
        const dropZone = document.getElementById('dropZone');
        dropZone.addEventListener('dragover', (event) => {
            event.preventDefault();
            dropZone.style.backgroundColor = '#f0f8ff';
        });

        dropZone.addEventListener('dragleave', (event) => {
            event.preventDefault();
            dropZone.style.backgroundColor = 'white';
        });

        dropZone.addEventListener('drop', (event) => {
            event.preventDefault();
            dropZone.style.backgroundColor = 'white';
            const files = event.dataTransfer.files;
            if (files.length > 0) {
                document.getElementById('editImage').files = files;
                previewImage({ target: document.getElementById('editImage') });
            }
        });
    </script>
@endsection
