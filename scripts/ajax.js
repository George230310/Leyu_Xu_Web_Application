// displayed by default
let initialEndPoint = "https://api.jikan.moe/v3/search/anime?q=&order_by=start_date&sort=desc&limit=50";
ajax(initialEndPoint, displayResults);


function displayResults(results){
    clearAll();
    let display_zone = document.querySelector("#results-display");
    let results_in_json = JSON.parse(results);
    let result_arr = results_in_json.results;

    document.querySelector("#num").innerHTML = result_arr.length;

    for(let i = 0; i < result_arr.length; i++)
    {
        let img_div = document.createElement("div");
        img_div.classList.add("col-12");
        img_div.classList.add("p-4");
        img_div.classList.add("col-md-4");
        img_div.classList.add("text-center");

        let poster = document.createElement("img");
        if(result_arr[i].image_url != null)
        {
            poster.src = result_arr[i].image_url;
            poster.alt = result_arr[i].title;
        }

        let title = document.createElement("div");
        title.classList.add("text-center");
        title.classList.add("fs-5");
        title.classList.add("white-font");
        title.innerHTML = result_arr[i].title;

        img_div.appendChild(poster);
        img_div.appendChild(title);

        let summary_div = document.createElement("div");
        summary_div.classList.add("col-12");
        summary_div.classList.add("p-4");
        summary_div.classList.add("col-md-8");
        summary_div.classList.add("normal-text");
        summary_div.classList.add("text-center");

        if(result_arr[i].synopsis != null && result_arr[i].synopsis != "")
        {
            summary_div.innerHTML = result_arr[i].synopsis;
        }
        else
        {
            summary_div.innerHTML = "NOT AVAILABLE";
        }
        

        display_zone.appendChild(img_div);
        display_zone.appendChild(summary_div);
    }
}

function clearAll()
{
    let display_zone = document.querySelector("#results-display");
    while(display_zone.hasChildNodes())
    {
        display_zone.removeChild(display_zone.lastChild);
    }
}


function ajax(endpoint, returnFunction)
{
    let httpRequest = new XMLHttpRequest();
    httpRequest.open("GET", endpoint);
    httpRequest.send();

    httpRequest.onreadystatechange = function(){
        if(httpRequest.readyState == 4)
        {
            if(httpRequest.status == 200)
            {
                returnFunction(httpRequest.responseText);
            }
            else
            {
                console.log("Connection Error");
                console.log(httpRequest.status);
            }
        }
    }
}

document.querySelector("#search-form").onsubmit = function(event){
    event.preventDefault();
    let query = document.querySelector("#keyword").value.trim();

    if(query.length >= 3)
    {
        document.querySelector("#keyword").value = "";
        let searchEndPoint = `https://api.jikan.moe/v3/search/anime?q=${query}&limit=50`;
        ajax(searchEndPoint, displayResults);
    }
    else
    {
        alert("Input at least 3 characters");
    }
}