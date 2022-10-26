function test(){
    alert("It works.");
}

data_and_hour();
set_data();

function reset_menu(){
    $("#menu-toggle").click();
    $("#menu-toggle").prop('checked', false);
    if(window.innerWidth > 795){
        $("#menu").css("display", "block");
        $("#menu-toggle").val(1);
    }
    else{
        $("#menu").css("display", "none");
        $("#menu-toggle").val(0);
        $(".list").css('display', 'none');
    }
}

function show_menu(){
    let k = $("#menu-toggle").val();
    if(k==1){ 
        $("#menu").hide();
        /*$("#menu").css("display", "none");*/
        $("#menu-toggle").val(0);
        $("#box-articole").css('top', '150px');
        $(".admin_section").css('top', 0 + 'px');
        $("#articol_nou").css('top', 'auto');
    }
    else { 
        $("#menu").slideDown("slow");
        /*$("#menu").css("display", "block");*/
        $("#menu-toggle").val(1);
        $(".list").css('display', 'flex');
        let h = parseInt($(".list").css("height").replace ( /[^\d.]/g, '' )) + 150;
        $("#box-articole").css('top', h + 'px');
        $(".admin_section").css('top', h + 'px');
        $("#articol_nou").css('top', h + 'px');
    }
}

function addZero(i) {
    if (i < 10) {i = "0" + i}
    return i;
  }

function data_and_hour()
{
    let ora = document.getElementById('ora');
    ora.innerHTML = addZero(new Date().getHours());
    document.getElementById('minute').innerHTML = addZero(new Date().getMinutes())
    document.getElementById('minute').classList.add("outputOra");
    ora.classList.add("outputOra");
    if(new Date().getHours() == 0)
    {
        set_data();
    }
    setTimeout(data_and_hour, 60000 - new Date().getSeconds()*1000);
}

function set_data()
{
    let data = new Date();
    document.getElementById('data').innerHTML = addZero(data.getDate()) + "." + addZero(data.getMonth()+1) + "." + data.getFullYear();
}

function articles_from_json(){
    fetch("articles.json")
        .then(response => response.json())
        .then(data => {
            let articole = data.articles;
            let nr_articole = articole.length;
            /*let article_list = document.createElement("div");
            article_list.className = "articles_box";*/
            let article_list = document.getElementById("box-articole");
            for(let i = nr_articole-1; i >= 0 ; i--){
                let card_articol = document.createElement("div");
                card_articol.className = "card-articol";
                let titlu = document.createElement("h1");
                let tp = document.createElement("p");
                let t = document.createElement("p");
                let imgg = document.createElement("img");
                titlu.innerHTML = articole[i]["title"];
                tp.innerHTML = articole[i]["text preview"];
                t.innerHTML = articole[i]["text"];
                imgg.src = articole[i]["image"];
                let img = document.createElement("div");
                img.appendChild(imgg);
                img.setAttribute("class", "imagine_card_articol");
                card_articol.appendChild(img);
                /*card_articol.appendChild(titlu);
                card_articol.appendChild(tp);
                //card_articol.appendChild(t);*/
                let texts = document.createElement("div");
                texts.className = "texts";
                texts.appendChild(titlu);
                texts.appendChild(tp);
                card_articol.appendChild(texts);
                let lk = document.createElement("a");
                //lk.onclick = "open_article()";
                //lk.setAttribute("value", i);
                lk.setAttribute("href", "articol.php?id_articol="+i);
                lk.appendChild(card_articol);
                article_list.appendChild(lk);
            }
            let add_button = document.createElement("button");
            add_button.innerHTML = "Post something";
            //article_list.appendChild(add_button);
            document.body.appendChild(article_list);
        });
}

articles_from_json();

/*function confirmareStergere(id) {
    jQuery.ajax({
        type: "POST",
        url: './includes/functions.inc.php',
        dataType: 'json',
        data: {functionname: 'delete-articol', arguments: id},
    
        success: function (obj, textstatus) {
                      if( !('error' in obj) ) {
                          yourVariable = obj.result;
                      }
                      else {
                          console.log(obj.error);
                      }
                }
    });
    
}

function confirmareEditare(id) {
    alert(id);
}*/