let add_room_form = document.getElementById('add_room_form');
let edit_room_form = document.getElementById('edit_room_form');
let add_image_form = document.getElementById('add_image_form');

add_room_form.addEventListener('submit', function(e){
    e.preventDefault();
    add_room();
});

function add_room()
{
    let data = new FormData();
    data.append('add_room','');
    data.append('name',add_room_form.elements['name'].value);
    data.append('area',add_room_form.elements['area'].value);
    data.append('price',add_room_form.elements['price'].value);
    data.append('quantity',add_room_form.elements['quantity'].value);
    data.append('adult',add_room_form.elements['adult'].value);
    data.append('children',add_room_form.elements['children'].value);
    data.append('desc',add_room_form.elements['desc'].value);

    let features = [];
    add_room_form.elements['features'].forEach(el => {
        if(el.checked){
            features.push(el.value);
        }
    });

    let facilities = [];
    add_room_form.elements['facilities'].forEach(el => {
        if(el.checked){
            facilities.push(el.value);
        }
    });

    data.append('features',JSON.stringify(features));
    data.append('facilities',JSON.stringify(facilities));

    let xhr = new XMLHttpRequest();
    xhr.open("POST","ajax/rooms_crud.php",true);

    xhr.onload = function(){
        var myModal = document.getElementById('add-room');
        var modal = bootstrap.Modal.getInstance(myModal); // Returns a Bootstrap modal instance
        modal.hide();

        if(this.responseText == 1)
        {
            alert('success','New room added!');
            add_room_form.reset();
            get_all_rooms();
        }
        else{
            alert('error','Server Down!');
        }
    }
    xhr.send(data);
}

function get_all_rooms()
{
    let xhr = new XMLHttpRequest();
    xhr.open("POST","ajax/rooms_crud.php",true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function(){
        document.getElementById('room-data').innerHTML = xhr.responseText;
    }
    xhr.send('get_all_rooms');
}

function toggle_status(id,val)
{
    let xhr = new XMLHttpRequest();
    xhr.open("POST","ajax/rooms_crud.php",true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function(){
        if(this.responseText==1){
            alert('success','Status toggled!');
            get_all_rooms();
        }
        else{
            alert('error','Server Down!');
        }
    }
    xhr.send('toggle_status='+id+'&value='+val);
}

function edit_details(id)
{
    let xhr = new XMLHttpRequest();
    xhr.open("POST","ajax/rooms_crud.php",true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function(){
        let data = JSON.parse(this.responseText);
        edit_room_form.elements['name'].value = data.room_data.name;
        edit_room_form.elements['area'].value = data.room_data.area;
        edit_room_form.elements['price'].value = data.room_data.price;
        edit_room_form.elements['quantity'].value = data.room_data.quantity;
        edit_room_form.elements['adult'].value = data.room_data.adult;
        edit_room_form.elements['children'].value = data.room_data.children;
        edit_room_form.elements['desc'].value = data.room_data.description;
        edit_room_form.elements['room_id'].value = data.room_data.id;

        edit_room_form.elements['features'].forEach(el => {
        // we have to use Number here because json always return in the form of string
        if(data.features.includes(Number(el.value))){
            el.checked = true;
        }
        });

        edit_room_form.elements['facilities'].forEach(el => {
        // we have to use Number here because json always return in the form of string
        if(data.facilities.includes(Number(el.value))){
            el.checked = true;
        }
        });
    }
    xhr.send('get_room='+id);
}

edit_room_form.addEventListener('submit', function(e){
    e.preventDefault();
    submit_edit_room();
});

function submit_edit_room()
{
    let data = new FormData();
    data.append('edit_room','');
    data.append('room_id',edit_room_form.elements['room_id'].value);
    data.append('name',edit_room_form.elements['name'].value);
    data.append('area',edit_room_form.elements['area'].value);
    data.append('price',edit_room_form.elements['price'].value);
    data.append('quantity',edit_room_form.elements['quantity'].value);
    data.append('adult',edit_room_form.elements['adult'].value);
    data.append('children',edit_room_form.elements['children'].value);
    data.append('desc',edit_room_form.elements['desc'].value);

    let features = [];
    edit_room_form.elements['features'].forEach(el => {
        if(el.checked){
            features.push(el.value);
        }
    });

    let facilities = [];
    edit_room_form.elements['facilities'].forEach(el => {
        if(el.checked){
            facilities.push(el.value);
        }
    });

    data.append('features',JSON.stringify(features));
    data.append('facilities',JSON.stringify(facilities));

    let xhr = new XMLHttpRequest();
    xhr.open("POST","ajax/rooms_crud.php",true);

    xhr.onload = function(){
        var myModal = document.getElementById('edit-room');
        var modal = bootstrap.Modal.getInstance(myModal); // Returns a Bootstrap modal instance
        modal.hide();

        if(this.responseText == 1)
        {
            alert('success','Room data edited!');
            edit_room_form.reset();
            get_all_rooms();
        }
        else{
            alert('error','Server Down!');
        }
    }
    xhr.send(data);
}

add_image_form.addEventListener('submit', function(e){
    e.preventDefault();
    add_image();
});

function add_image()
{
    let data = new FormData();
    data.append('image',add_image_form.elements['image'].files[0]);  // we are using file[0] for selecting only one file from folder
    data.append('room_id',add_image_form.elements['room_id'].value);
    data.append('add_image','');

    let xhr = new XMLHttpRequest();
    xhr.open("POST","ajax/rooms_crud.php",true);
    // xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');   // we are not using this because we want to sent data in the multi-part form which is already done by FormData() class

    xhr.onload = function()
    {
        if(this.responseText == 'inv_img')
        {
            alert('error','Only JPG, JPEG, WEBP and PNG images are allowed!','image-alert');
        }
        else if(this.responseText == 'inv_size')
        {
            alert('error','Image should be less than 2MB!','image-alert');
        }
        else if(this.responseText == 'upd_failed'){
            alert('error','Image upload failed. Server Down!','image-alert');
        }
        else{
            alert('success','New Image added!','image-alert');
            room_images(add_image_form.elements['room_id'].value,document.querySelector("#room-images .modal-title").innerText);
            add_image_form.reset();
        }
    }
    xhr.send(data);
}

function room_images(id, room_name)
{
    document.querySelector("#room-images .modal-title").innerText =room_name;
    add_image_form.elements['room_id'].value = id;
    add_image_form.elements['image'].value = "";

    let xhr = new XMLHttpRequest();
    xhr.open("POST","ajax/rooms_crud.php",true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function(){
        document.getElementById('room-image-data').innerHTML = this.responseText;
    }

    xhr.send('get_room_images='+id);
}

function rem_image(img_id, room_id)
{
    let data = new FormData();
    data.append('image_id',img_id);
    data.append('room_id',room_id);
    data.append('rem_image','');

    let xhr = new XMLHttpRequest();
    xhr.open("POST","ajax/rooms_crud.php",true);
    // xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');   // we are not using this because we want to sent data in the multi-part form which is already done by FormData() class

    xhr.onload = function()
    {
        if(this.responseText == 1)
        {
            alert('success','Image Removed!','image-alert');
            room_images(room_id ,document.querySelector("#room-images .modal-title").innerText);
        }
        else{
            alert('error','Image removal failed!','image-alert');
        }
    }
    xhr.send(data);
}

function thumb_image(img_id, room_id)
{
    let data = new FormData();
    data.append('image_id',img_id);
    data.append('room_id',room_id);
    data.append('thumb_image','');

    let xhr = new XMLHttpRequest();
    xhr.open("POST","ajax/rooms_crud.php",true);
    // xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');   // we are not using this because we want to sent data in the multi-part form which is already done by FormData() class

    xhr.onload = function()
    {
        if(this.responseText == 1)
        {
            alert('success','Image Thumbnail Changed!','image-alert');
            room_images(room_id ,document.querySelector("#room-images .modal-title").innerText);
        }
        else{
            alert('error','Thumbnail removal failed!','image-alert');
        }
    }
    xhr.send(data);
}

function remove_room(room_id)
{
    if(confirm('Are you sure you want to delete this room?')){
        let data = new FormData();
        data.append('room_id',room_id);
        data.append('remove_room','');
        let xhr = new XMLHttpRequest();
        xhr.open("POST","ajax/rooms_crud.php",true);

        xhr.onload = function()
        {
            if(this.responseText == 1)
            {
                alert('success','Room Removed!');
                get_all_rooms();
            }
            else{
                alert('error','Room removal failed!');
            }
        }
        xhr.send(data);

    }
}

window.onload = function(){
    get_all_rooms();
}