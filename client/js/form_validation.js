function validateCreatePost() {
    var title = document.forms["create-post"]["title"].value;
    if (title == "") {
        alert("Title must be filled in");
        return false;
    }
    if (title.length > 50){
        alert("Title length must be less than 50 characters");
        return false;
    }

    var body = document.forms["create-post"]["body"].value;
    if (body == ""){
        alert("Body must be filled in");
        return false;
    }
    if (body.length > 250){
        alert("Body must be less than 250 characters");
        return false;
    }
    return true;
}