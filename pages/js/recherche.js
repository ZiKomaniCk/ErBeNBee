function init(){
    var search_bar = document.getElementById("search_bar");
    
    search_bar.addEventListener("keyup", function(e){
        
        if ((e.keyCode >= 65 && e.keyCode <= 90) || (e.keyCode >= 97 && e.keyCode <= 122)){
            var keywords = e.target.value;
            
            var xhr = new XMLHttpRequest();
            
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
                    console.log(xhr.responseText);
                    
                    var req = JSON.parse(xhr.responseText);
                }
            };
            
            var formData = new FormData();
            formData.append("keywords", keywords);
            
            xhr.open("POST", "function/script/script.php", true);
            xhr.send(formData);   
        }
    });
    
}
window.onload = init;