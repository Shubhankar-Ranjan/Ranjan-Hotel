<?php
    require('inc/essentials.php');
    adminLogin();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - SETTINGS</title>
    <?php require('inc/links.php'); ?>
</head>
<body class="bg-light">
    
    <?php require('inc/header.php'); ?>

    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h3 class="mb-4">SETTINGS</h3>

                <!-- General settings section -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3 ">
                            <h5 class="card-title m-0">General Settings</h5>
                            <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#general-s">
                                <i class="bi bi-pencil-square me-1"></i>Edit
                            </button>
                        </div>
                        <h6 class="card-subtitle mb-1 fw-bold">Site Title</h6>
                        <p class="card-text" id="site_title"></p>
                        <h6 class="card-subtitle mb-1 fw-bold">About us</h6>
                        <p class="card-text" id="site_about">content</p>
                    </div>
                </div>

                <!-- General Settings Modal -->
                <div class="modal fade" id="general-s" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <form id="general_s_form">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">General Settings</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Site Title</label>
                                        <input type="text" name="site_title" id="site_title_inp" class="form-control shadow-none" required>
                                    </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">About Us</label>
                                            <textarea name="site_about" id="site_about_inp" class="form-control shadow-none"rows="6" required></textarea>
                                        </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" onclick="site_title.value = general_data.site_title, site_about.value = general_data.site_about" class="btn text-secondary shadow-none" data-bs-dismiss="modal">CANCEL</button>
                                    <button type="submit" class="btn custom-bg text-white shadow-none">SUBMIT</button>
                                </div>
                            </div>
                        </form>
                        
                    </div>
                </div>

                <!-- Shutdown section = The payment and booking will close for customers -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3 ">
                            <h5 class="card-title m-0">Shutdown Website</h5>
                            <div class="form-check form-switch">
                                <form>
                                    <input onchange="upd_shutdown(this.value)" class="form-check-input" type="checkbox" id="shutdown-toggle">
                                </form>
                            </div>    
                        </div>
                        <p class="card-text" id="site_about">
                            No customers will be allowed to book hotel room, when shutdown mode is turned on.
                        </p>
                    </div>
                </div>

                <!-- Contact details section -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3 ">
                            <h5 class="card-title m-0">Contact Settings</h5>
                            <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#contact-s">
                                <i class="bi bi-pencil-square me-1"></i>Edit
                            </button>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-4">
                                    <h6 class="card-subtitle mb-1 fw-bold">Address</h6>
                                    <p class="card-text" id="address"></p>
                                </div>
                                <div class="mb-4">
                                    <h6 class="card-subtitle mb-1 fw-bold">Google Map</h6>
                                    <p class="card-text" id="gmap"></p>
                                </div>
                                <div class="mb-4">
                                    <h6 class="card-subtitle mb-1 fw-bold">Phone Numbers</h6>
                                    <p class="card-text mb-1">
                                        <i class="bi bi-telephone-fill"></i>
                                        <span id="pn1"></span>
                                    </p>
                                    <p class="card-text">
                                        <i class="bi bi-telephone-fill"></i>
                                        <span id="pn2"></span>
                                    </p>
                                </div>
                                <div class="mb-4">
                                    <h6 class="card-subtitle mb-1 fw-bold">E-mail</h6>
                                    <p class="card-text" id="email"></p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-4">
                                    <h6 class="card-subtitle mb-1 fw-bold">Social Links</h6>
                                    <p class="card-text mb-1">
                                        <i class="bi bi-facebook me-1"></i>
                                        <span id="fb"></span>
                                    </p>
                                    <p class="card-text mb-1">
                                        <i class="bi bi-instagram me-1"></i>
                                        <span id="insta"></span>
                                    </p>
                                    <p class="card-text">
                                        <i class="bi bi-twitter me-1"></i>
                                        <span id="tw"></span>
                                    </p>
                                </div>
                                <div class="mb-4">
                                    <h6 class="card-subtitle mb-1 fw-bold">iFrame</h6>
                                    <iframe id="iframe" class="border p-2 w-100 " loading="lazy"></iframe>
                                </div>
                                    
                                
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>



    <?php require('inc/scripts.php'); ?>
    <script>
        let general_data, contacts_data;

        let general_s_form = document.getElementById('general_s_form');

        let site_title_inp = document.getElementById('site_title_inp');
        let site_about_inp = document.getElementById('site_about_inp');

        function get_general()
        {
            let site_title = document.getElementById('site_title');
            let site_about = document.getElementById('site_about');

            let shutdown_toggle = document.getElementById('shutdown-toggle')

            let xhr = new XMLHttpRequest();
            xhr.open("POST","ajax/settings_crud.php",true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.onload = function(){
                general_data = JSON.parse(this.responseText);

                // we are using innerText instead of innerHTML because we only need to put small data
                site_title.innerText = general_data.site_title;
                site_about.innerText = general_data.site_about;

                site_title_inp.value = general_data.site_title;
                site_about_inp.value = general_data.site_about;

                if(general_data.shutdown == 0){
                    shutdown_toggle.checked = false;
                    shutdown_toggle.value = 0;
                }
                else{
                    shutdown_toggle.checked = true;
                    shutdown_toggle.value = 1;
                }
            }
            xhr.send('get_general');
        }

        general_s_form.addEventListener('submit',function(e){
            e.preventDefault();
            upd_general(site_title_inp.value,site_about_inp.value);
        })

        function upd_general(site_title_val,site_about_val) 
        {
            let xhr = new XMLHttpRequest();
            xhr.open("POST","ajax/settings_crud.php",true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.onload = function(){

                var myModal = document.getElementById('general-s')
                var modal = bootstrap.Modal.getInstance(myModal) // Returns a Bootstrap modal instance
                modal.hide();

                if(this.responseText == 1)
                {
                    alert('success','Changes saved!');
                    get_general();
                }
                else
                {
                    alert('error','No Changes made!');
                }

            }
            xhr.send('site_title='+site_title_val+'&site_about='+site_about_val+'&upd_general');
        }

        function upd_shutdown(val)
        {
            let xhr = new XMLHttpRequest();
            xhr.open("POST","ajax/settings_crud.php",true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.onload = function(){
                if(this.responseText == 1  && general_data.shutdown == 0) //if general_data previous value is 0 and now response is 1
                {
                    alert('success','Site has been shutdown!');
                }
                else
                {
                    alert('success','Site has opened!');
                }
                get_general();

            }
            xhr.send('upd_shutdown='+val);
        }

        function get_contacts()
        {
            let contacts_p_id = ['address','gmap','pn1','pn2','email','fb','insta','tw'];
            let iframe = document.getElementById('iframe');

            let xhr = new XMLHttpRequest();
            xhr.open("POST","ajax/settings_crud.php",true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.onload = function(){
                contacts_data = JSON.parse(this.responseText);
                contacts_data = Object.values(contacts_data);

                for(i=0;i<contacts_p_id.length;i++){
                    document.getElementById(contacts_p_id[i]).innerText = contacts_data[i+1];
                }
                
            }
            xhr.send('get_contacts');
        }

        window.onload = function(){
            get_general();
            get_contacts();
        }

    </script>
</body>
</html>