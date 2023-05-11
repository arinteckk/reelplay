	    <!-- Start: Javascript -->
        <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/js/popper.min.js') }}"></script>
        <script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
        <!-- Video Play Model script -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <!-- Datatable -->
        <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('assets/js/dataTables.bootstrap4.min.js') }}"></script>
        <!-- Feather Icon -->
        <script src="{{ asset('https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js') }}"></script>
        
        <script src="{{ asset('/assets/js/js.js')}}"></script>
        <!-- Toastr -->
        <script src="{{ asset('/assets/js/toastr.min.js')}}"></script>
        <!-- chart -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.js"></script>
        <!-- Select2 -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
        <!-- Chunk JS -->
        <!-- 1 file -->
        <script src="{{ asset('/assets/js/plupload.full.min.js')}}"></script>
        <!-- 2 file -->
        <script src="{{ asset('/assets/js/common.js')}}"></script>
        <script>
            function get_responce_message(resp, form_name="", url="") {
                if (resp.status == '200') {
                    toastr.success(resp.success);
                    document.getElementById(form_name).reset();
                    if(url !=""){
                        setTimeout(function() {
                            window.location.replace(url);
                        }, 500);
                    }
                } else {
                    var obj = resp.errors;
                    if (typeof obj === 'string') {
                        toastr.error(obj);
                    } else {
                        $.each(obj, function(i, e) {
                            toastr.error(e);
                        });
                    }
                }
            }

            // Banner Toastr Msg
            function get_responce_message2(resp, form_name="", url="", status) {
                if (resp.status == '200') {
                    // toastr.success(resp.success);
                    // document.getElementById(form_name).reset();
                    if(status == 2){
                        localStorage.setItem("Status2",resp.success)
                    } else if (status == 3) {
                        localStorage.setItem("Status3",resp.success)
                    } else {
                        localStorage.setItem("Status1",resp.success)
                    }

                    setTimeout(function() {
                        window.location.replace(url);
                    }, 500);
                } else {
                    var obj = resp.errors;
                    if (typeof obj === 'string') {
                        toastr.error(obj);
                    } else {
                        $.each(obj, function(i, e) {
                            toastr.error(e);
                        });
                    }
                }
            }
            $(document).ready(function(){
                //get it if Status key found
                if(localStorage.getItem("Status2"))
                {
                    toastr.success("Data Deleted SuccessFully.");
                    localStorage.clear();
                }
                if(localStorage.getItem("Status1"))
                {
                    toastr.success("Data Added SuccessFully.");
                    localStorage.clear();
                }
                if(localStorage.getItem("Status3"))
                {
                    toastr.success("Data Updated SuccessFully.");
                    localStorage.clear();
                }
            });

            function get_responce_message1(resp, url="") {
                if (resp.status == '200') {
                    toastr.success(resp.success);
                    setTimeout(function() {
                        window.location.replace(url);
                    }, 500);
                } else {
                    var obj = resp.errors;
                    if (typeof obj === 'string') {
                        toastr.error(obj);
                    } else {
                        $.each(obj, function(i, e) {
                            toastr.error(e);
                        });
                    }
                }
            }
            $(document).ready(function() {
                @if(Session::has('error'))
                    toastr.error('{{ Session::get('error') }}');
                @elseif(Session::has('success'))
                    toastr.success('{{ Session::get('success') }}');
                @endif

                $('#image').change(function(){
                    let reader = new FileReader();
                    reader.onload = (e) => { 
                        $('#preview-image-before-upload').attr('src', e.target.result); 
                    }
                    reader.readAsDataURL(this.files[0]); 
                });

                $('#thumbnail').change(function() {
                    let reader = new FileReader();
                    reader.onload = (e) => {
                        $('#preview-image-before-upload').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(this.files[0]);
                });

                $('#landscape').change(function() {
                    let reader = new FileReader();
                    reader.onload = (e) => {
                        $('#preview-image-before-upload1').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(this.files[0]);
                });
            });
        </script>
    </body>
</html>