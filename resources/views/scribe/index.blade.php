<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Laravel API Documentation</title>

    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset("/vendor/scribe/css/theme-default.style.css") }}" media="screen">
    <link rel="stylesheet" href="{{ asset("/vendor/scribe/css/theme-default.print.css") }}" media="print">

    <script src="https://cdn.jsdelivr.net/npm/lodash@4.17.10/lodash.min.js"></script>

    <link rel="stylesheet"
          href="https://unpkg.com/@highlightjs/cdn-assets@11.6.0/styles/obsidian.min.css">
    <script src="https://unpkg.com/@highlightjs/cdn-assets@11.6.0/highlight.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jets/0.14.1/jets.min.js"></script>

    <style id="language-style">
        /* starts out as display none and is replaced with js later  */
                    body .content .bash-example code { display: none; }
                    body .content .javascript-example code { display: none; }
            </style>

    <script>
        var tryItOutBaseUrl = "http://localhost";
        var useCsrf = Boolean();
        var csrfUrl = "/sanctum/csrf-cookie";
    </script>
    <script src="{{ asset("/vendor/scribe/js/tryitout-5.11.0.js") }}"></script>

    <script src="{{ asset("/vendor/scribe/js/theme-default-5.11.0.js") }}"></script>

</head>

<body data-languages="[&quot;bash&quot;,&quot;javascript&quot;]">

<a href="#" id="nav-button">
    <span>
        MENU
        <img src="{{ asset("/vendor/scribe/images/navbar.png") }}" alt="navbar-image"/>
    </span>
</a>
<div class="tocify-wrapper">
    
            <div class="lang-selector">
                                            <button type="button" class="lang-button" data-language-name="bash">bash</button>
                                            <button type="button" class="lang-button" data-language-name="javascript">javascript</button>
                    </div>
    
    <div class="search">
        <input type="text" class="search" id="input-search" placeholder="Search">
    </div>

    <div id="toc">
                    <ul id="tocify-header-introduction" class="tocify-header">
                <li class="tocify-item level-1" data-unique="introduction">
                    <a href="#introduction">Introduction</a>
                </li>
                            </ul>
                    <ul id="tocify-header-authenticating-requests" class="tocify-header">
                <li class="tocify-item level-1" data-unique="authenticating-requests">
                    <a href="#authenticating-requests">Authenticating requests</a>
                </li>
                            </ul>
                    <ul id="tocify-header-endpoints" class="tocify-header">
                <li class="tocify-item level-1" data-unique="endpoints">
                    <a href="#endpoints">Endpoints</a>
                </li>
                                    <ul id="tocify-subheader-endpoints" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="endpoints-POSTapi-auth-register">
                                <a href="#endpoints-POSTapi-auth-register">POST api/auth/register</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-auth-login">
                                <a href="#endpoints-POSTapi-auth-login">POST api/auth/login</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-cars">
                                <a href="#endpoints-GETapi-cars">GET api/cars</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-cars--car_id-">
                                <a href="#endpoints-GETapi-cars--car_id-">GET api/cars/{car_id}</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-catalog-makers">
                                <a href="#endpoints-GETapi-catalog-makers">GET api/catalog/makers</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-catalog-fuel-types">
                                <a href="#endpoints-GETapi-catalog-fuel-types">GET api/catalog/fuel-types</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-catalog-car-types">
                                <a href="#endpoints-GETapi-catalog-car-types">GET api/catalog/car-types</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-admin-users">
                                <a href="#endpoints-GETapi-admin-users">GET api/admin/users</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-auth-logout">
                                <a href="#endpoints-POSTapi-auth-logout">POST api/auth/logout</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-auth-me">
                                <a href="#endpoints-GETapi-auth-me">GET api/auth/me</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-user-me">
                                <a href="#endpoints-GETapi-user-me">GET api/user/me</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-user-favourites">
                                <a href="#endpoints-GETapi-user-favourites">GET api/user/favourites</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-cars">
                                <a href="#endpoints-POSTapi-cars">POST api/cars</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-PUTapi-cars--car_id-">
                                <a href="#endpoints-PUTapi-cars--car_id-">PUT api/cars/{car_id}</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-DELETEapi-cars--car_id-">
                                <a href="#endpoints-DELETEapi-cars--car_id-">DELETE api/cars/{car_id}</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-cars--car_id--favourite">
                                <a href="#endpoints-POSTapi-cars--car_id--favourite">POST api/cars/{car_id}/favourite</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-favourites">
                                <a href="#endpoints-GETapi-favourites">GET api/favourites</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-favourites--car_id-">
                                <a href="#endpoints-GETapi-favourites--car_id-">GET api/favourites/{car_id}</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-favourites--car_id-">
                                <a href="#endpoints-POSTapi-favourites--car_id-">POST api/favourites/{car_id}</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-PUTapi-favourites--car_id-">
                                <a href="#endpoints-PUTapi-favourites--car_id-">PUT api/favourites/{car_id}</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-DELETEapi-favourites--car_id-">
                                <a href="#endpoints-DELETEapi-favourites--car_id-">DELETE api/favourites/{car_id}</a>
                            </li>
                                                                        </ul>
                            </ul>
            </div>

    <ul class="toc-footer" id="toc-footer">
                    <li style="padding-bottom: 5px;"><a href="{{ route("scribe.postman") }}">View Postman collection</a></li>
                            <li style="padding-bottom: 5px;"><a href="{{ route("scribe.openapi") }}">View OpenAPI spec</a></li>
                <li><a href="http://github.com/knuckleswtf/scribe">Documentation powered by Scribe ✍</a></li>
    </ul>

    <ul class="toc-footer" id="last-updated">
        <li>Last updated: June 14, 2026</li>
    </ul>
</div>

<div class="page-wrapper">
    <div class="dark-box"></div>
    <div class="content">
        <h1 id="introduction">Introduction</h1>
<aside>
    <strong>Base URL</strong>: <code>http://localhost</code>
</aside>
<pre><code>This documentation aims to provide all the information you need to work with our API.

&lt;aside&gt;As you scroll, you'll see code examples for working with the API in different programming languages in the dark area to the right (or as part of the content on mobile).
You can switch the language used with the tabs at the top right (or from the nav menu at the top left on mobile).&lt;/aside&gt;</code></pre>

        <h1 id="authenticating-requests">Authenticating requests</h1>
<p>This API is not authenticated.</p>

        <h1 id="endpoints">Endpoints</h1>

    

                                <h2 id="endpoints-POSTapi-auth-register">POST api/auth/register</h2>

<p>
</p>



<span id="example-requests-POSTapi-auth-register">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost/api/auth/register" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"name\": \"Iker Martínez\",
    \"email\": \"iker@example.com\",
    \"phone\": \"600123456\",
    \"password\": \"Password123\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/auth/register"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "Iker Martínez",
    "email": "iker@example.com",
    "phone": "600123456",
    "password": "Password123"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-auth-register">
</span>
<span id="execution-results-POSTapi-auth-register" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-auth-register"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-auth-register"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-auth-register" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-auth-register">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-auth-register" data-method="POST"
      data-path="api/auth/register"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-auth-register', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-auth-register"
                    onclick="tryItOut('POSTapi-auth-register');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-auth-register"
                    onclick="cancelTryOut('POSTapi-auth-register');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-auth-register"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/auth/register</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-auth-register"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-auth-register"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="name"                data-endpoint="POSTapi-auth-register"
               value="Iker Martínez"
               data-component="body">
    <br>
<p>Nombre completo del usuario. Must not be greater than 255 characters. Example: <code>Iker Martínez</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>email</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="email"                data-endpoint="POSTapi-auth-register"
               value="iker@example.com"
               data-component="body">
    <br>
<p>Correo electrónico único. Se guarda en minúsculas. Must be a valid email address. Must not be greater than 255 characters. Example: <code>iker@example.com</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>phone</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="phone"                data-endpoint="POSTapi-auth-register"
               value="600123456"
               data-component="body">
    <br>
<p>Teléfono de contacto del usuario. Must not be greater than 20 characters. Example: <code>600123456</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>password</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="password"                data-endpoint="POSTapi-auth-register"
               value="Password123"
               data-component="body">
    <br>
<p>Contraseña. Debe cumplir las reglas mínimas de seguridad. Example: <code>Password123</code></p>
        </div>
        </form>

                    <h2 id="endpoints-POSTapi-auth-login">POST api/auth/login</h2>

<p>
</p>



<span id="example-requests-POSTapi-auth-login">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost/api/auth/login" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"email\": \"iker@example.com\",
    \"password\": \"Password123\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/auth/login"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "email": "iker@example.com",
    "password": "Password123"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-auth-login">
</span>
<span id="execution-results-POSTapi-auth-login" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-auth-login"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-auth-login"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-auth-login" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-auth-login">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-auth-login" data-method="POST"
      data-path="api/auth/login"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-auth-login', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-auth-login"
                    onclick="tryItOut('POSTapi-auth-login');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-auth-login"
                    onclick="cancelTryOut('POSTapi-auth-login');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-auth-login"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/auth/login</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-auth-login"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-auth-login"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>email</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="email"                data-endpoint="POSTapi-auth-login"
               value="iker@example.com"
               data-component="body">
    <br>
<p>Correo electrónico de la cuenta. Must be a valid email address. Example: <code>iker@example.com</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>password</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="password"                data-endpoint="POSTapi-auth-login"
               value="Password123"
               data-component="body">
    <br>
<p>Contraseña de la cuenta. Example: <code>Password123</code></p>
        </div>
        </form>

                    <h2 id="endpoints-GETapi-cars">GET api/cars</h2>

<p>
</p>



<span id="example-requests-GETapi-cars">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/cars" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/cars"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-cars">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;data&quot;: [
        {
            &quot;id&quot;: 98,
            &quot;precio&quot;: 7000,
            &quot;anyo&quot;: 2024,
            &quot;km&quot;: 13000,
            &quot;vehiculo&quot;: {
                &quot;maker&quot;: &quot;Ford&quot;,
                &quot;model&quot;: &quot;Escape&quot;,
                &quot;car_type&quot;: &quot;Hatchback&quot;
            },
            &quot;ubicacion&quot;: &quot;Albany&quot;,
            &quot;imagen_principal&quot;: &quot;https://loremflickr.com/800/600/car,ford?lock=98&quot;
        },
        {
            &quot;id&quot;: 97,
            &quot;precio&quot;: 87000,
            &quot;anyo&quot;: 2001,
            &quot;km&quot;: 311000,
            &quot;vehiculo&quot;: {
                &quot;maker&quot;: &quot;Ford&quot;,
                &quot;model&quot;: &quot;Escape&quot;,
                &quot;car_type&quot;: &quot;Sedan&quot;
            },
            &quot;ubicacion&quot;: &quot;San Francisco&quot;,
            &quot;imagen_principal&quot;: &quot;https://loremflickr.com/800/600/car,ford?lock=97&quot;
        },
        {
            &quot;id&quot;: 96,
            &quot;precio&quot;: 41000,
            &quot;anyo&quot;: 1997,
            &quot;km&quot;: 239000,
            &quot;vehiculo&quot;: {
                &quot;maker&quot;: &quot;Ford&quot;,
                &quot;model&quot;: &quot;F-150&quot;,
                &quot;car_type&quot;: &quot;Jeep&quot;
            },
            &quot;ubicacion&quot;: &quot;San Francisco&quot;,
            &quot;imagen_principal&quot;: &quot;https://loremflickr.com/800/600/car,ford?lock=96&quot;
        },
        {
            &quot;id&quot;: 94,
            &quot;precio&quot;: 43000,
            &quot;anyo&quot;: 1972,
            &quot;km&quot;: 20000,
            &quot;vehiculo&quot;: {
                &quot;maker&quot;: &quot;Toyota&quot;,
                &quot;model&quot;: &quot;Corolla&quot;,
                &quot;car_type&quot;: &quot;Hatchback&quot;
            },
            &quot;ubicacion&quot;: &quot;New York City&quot;,
            &quot;imagen_principal&quot;: &quot;https://loremflickr.com/800/600/car,toyota?lock=94&quot;
        },
        {
            &quot;id&quot;: 91,
            &quot;precio&quot;: 6000,
            &quot;anyo&quot;: 1974,
            &quot;km&quot;: 442000,
            &quot;vehiculo&quot;: {
                &quot;maker&quot;: &quot;Ford&quot;,
                &quot;model&quot;: &quot;F-150&quot;,
                &quot;car_type&quot;: &quot;Crossover&quot;
            },
            &quot;ubicacion&quot;: &quot;San Francisco&quot;,
            &quot;imagen_principal&quot;: &quot;https://loremflickr.com/800/600/car,ford?lock=91&quot;
        },
        {
            &quot;id&quot;: 90,
            &quot;precio&quot;: 11000,
            &quot;anyo&quot;: 1989,
            &quot;km&quot;: 179000,
            &quot;vehiculo&quot;: {
                &quot;maker&quot;: &quot;Toyota&quot;,
                &quot;model&quot;: &quot;Corolla&quot;,
                &quot;car_type&quot;: &quot;Coupe&quot;
            },
            &quot;ubicacion&quot;: &quot;San Diego&quot;,
            &quot;imagen_principal&quot;: &quot;https://loremflickr.com/800/600/car,toyota?lock=90&quot;
        },
        {
            &quot;id&quot;: 87,
            &quot;precio&quot;: 37000,
            &quot;anyo&quot;: 2019,
            &quot;km&quot;: 177000,
            &quot;vehiculo&quot;: {
                &quot;maker&quot;: &quot;Toyota&quot;,
                &quot;model&quot;: &quot;RAV4&quot;,
                &quot;car_type&quot;: &quot;Crossover&quot;
            },
            &quot;ubicacion&quot;: &quot;San Diego&quot;,
            &quot;imagen_principal&quot;: &quot;https://loremflickr.com/800/600/car,toyota?lock=87&quot;
        },
        {
            &quot;id&quot;: 86,
            &quot;precio&quot;: 48000,
            &quot;anyo&quot;: 1974,
            &quot;km&quot;: 188000,
            &quot;vehiculo&quot;: {
                &quot;maker&quot;: &quot;Toyota&quot;,
                &quot;model&quot;: &quot;RAV4&quot;,
                &quot;car_type&quot;: &quot;Hatchback&quot;
            },
            &quot;ubicacion&quot;: &quot;Albany&quot;,
            &quot;imagen_principal&quot;: &quot;https://loremflickr.com/800/600/car,toyota?lock=86&quot;
        },
        {
            &quot;id&quot;: 85,
            &quot;precio&quot;: 32000,
            &quot;anyo&quot;: 1984,
            &quot;km&quot;: 36000,
            &quot;vehiculo&quot;: {
                &quot;maker&quot;: &quot;Toyota&quot;,
                &quot;model&quot;: &quot;Camry&quot;,
                &quot;car_type&quot;: &quot;Coupe&quot;
            },
            &quot;ubicacion&quot;: &quot;San Diego&quot;,
            &quot;imagen_principal&quot;: &quot;https://loremflickr.com/800/600/car,toyota?lock=85&quot;
        },
        {
            &quot;id&quot;: 84,
            &quot;precio&quot;: 54000,
            &quot;anyo&quot;: 1979,
            &quot;km&quot;: 360000,
            &quot;vehiculo&quot;: {
                &quot;maker&quot;: &quot;Toyota&quot;,
                &quot;model&quot;: &quot;RAV4&quot;,
                &quot;car_type&quot;: &quot;Pickup Truck&quot;
            },
            &quot;ubicacion&quot;: &quot;Buffalo&quot;,
            &quot;imagen_principal&quot;: &quot;https://loremflickr.com/800/600/car,toyota?lock=84&quot;
        },
        {
            &quot;id&quot;: 83,
            &quot;precio&quot;: 34000,
            &quot;anyo&quot;: 2007,
            &quot;km&quot;: 89000,
            &quot;vehiculo&quot;: {
                &quot;maker&quot;: &quot;Toyota&quot;,
                &quot;model&quot;: &quot;RAV4&quot;,
                &quot;car_type&quot;: &quot;Sedan&quot;
            },
            &quot;ubicacion&quot;: &quot;Buffalo&quot;,
            &quot;imagen_principal&quot;: &quot;https://loremflickr.com/800/600/car,toyota?lock=83&quot;
        },
        {
            &quot;id&quot;: 82,
            &quot;precio&quot;: 79000,
            &quot;anyo&quot;: 1996,
            &quot;km&quot;: 251000,
            &quot;vehiculo&quot;: {
                &quot;maker&quot;: &quot;Toyota&quot;,
                &quot;model&quot;: &quot;RAV4&quot;,
                &quot;car_type&quot;: &quot;Sedan&quot;
            },
            &quot;ubicacion&quot;: &quot;New York City&quot;,
            &quot;imagen_principal&quot;: &quot;https://loremflickr.com/800/600/car,toyota?lock=82&quot;
        },
        {
            &quot;id&quot;: 81,
            &quot;precio&quot;: 23000,
            &quot;anyo&quot;: 2009,
            &quot;km&quot;: 180000,
            &quot;vehiculo&quot;: {
                &quot;maker&quot;: &quot;Toyota&quot;,
                &quot;model&quot;: &quot;Camry&quot;,
                &quot;car_type&quot;: &quot;Sports Car&quot;
            },
            &quot;ubicacion&quot;: &quot;Albany&quot;,
            &quot;imagen_principal&quot;: &quot;https://loremflickr.com/800/600/car,toyota?lock=81&quot;
        },
        {
            &quot;id&quot;: 80,
            &quot;precio&quot;: 91000,
            &quot;anyo&quot;: 2026,
            &quot;km&quot;: 38000,
            &quot;vehiculo&quot;: {
                &quot;maker&quot;: &quot;Ford&quot;,
                &quot;model&quot;: &quot;Escape&quot;,
                &quot;car_type&quot;: &quot;Hatchback&quot;
            },
            &quot;ubicacion&quot;: &quot;Buffalo&quot;,
            &quot;imagen_principal&quot;: &quot;https://loremflickr.com/800/600/car,ford?lock=80&quot;
        },
        {
            &quot;id&quot;: 77,
            &quot;precio&quot;: 17000,
            &quot;anyo&quot;: 2019,
            &quot;km&quot;: 304000,
            &quot;vehiculo&quot;: {
                &quot;maker&quot;: &quot;Ford&quot;,
                &quot;model&quot;: &quot;Escape&quot;,
                &quot;car_type&quot;: &quot;Minivan&quot;
            },
            &quot;ubicacion&quot;: &quot;San Francisco&quot;,
            &quot;imagen_principal&quot;: &quot;https://loremflickr.com/800/600/car,ford?lock=77&quot;
        }
    ],
    &quot;links&quot;: {
        &quot;first&quot;: &quot;http://localhost/api/cars?page=1&quot;,
        &quot;last&quot;: &quot;http://localhost/api/cars?page=6&quot;,
        &quot;prev&quot;: null,
        &quot;next&quot;: &quot;http://localhost/api/cars?page=2&quot;
    },
    &quot;meta&quot;: {
        &quot;current_page&quot;: 1,
        &quot;from&quot;: 1,
        &quot;last_page&quot;: 6,
        &quot;links&quot;: [
            {
                &quot;url&quot;: null,
                &quot;label&quot;: &quot;&amp;laquo; Previous&quot;,
                &quot;page&quot;: null,
                &quot;active&quot;: false
            },
            {
                &quot;url&quot;: &quot;http://localhost/api/cars?page=1&quot;,
                &quot;label&quot;: &quot;1&quot;,
                &quot;page&quot;: 1,
                &quot;active&quot;: true
            },
            {
                &quot;url&quot;: &quot;http://localhost/api/cars?page=2&quot;,
                &quot;label&quot;: &quot;2&quot;,
                &quot;page&quot;: 2,
                &quot;active&quot;: false
            },
            {
                &quot;url&quot;: &quot;http://localhost/api/cars?page=3&quot;,
                &quot;label&quot;: &quot;3&quot;,
                &quot;page&quot;: 3,
                &quot;active&quot;: false
            },
            {
                &quot;url&quot;: &quot;http://localhost/api/cars?page=4&quot;,
                &quot;label&quot;: &quot;4&quot;,
                &quot;page&quot;: 4,
                &quot;active&quot;: false
            },
            {
                &quot;url&quot;: &quot;http://localhost/api/cars?page=5&quot;,
                &quot;label&quot;: &quot;5&quot;,
                &quot;page&quot;: 5,
                &quot;active&quot;: false
            },
            {
                &quot;url&quot;: &quot;http://localhost/api/cars?page=6&quot;,
                &quot;label&quot;: &quot;6&quot;,
                &quot;page&quot;: 6,
                &quot;active&quot;: false
            },
            {
                &quot;url&quot;: &quot;http://localhost/api/cars?page=2&quot;,
                &quot;label&quot;: &quot;Next &amp;raquo;&quot;,
                &quot;page&quot;: 2,
                &quot;active&quot;: false
            }
        ],
        &quot;path&quot;: &quot;http://localhost/api/cars&quot;,
        &quot;per_page&quot;: 15,
        &quot;to&quot;: 15,
        &quot;total&quot;: 80
    }
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-cars" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-cars"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-cars"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-cars" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-cars">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-cars" data-method="GET"
      data-path="api/cars"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-cars', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-cars"
                    onclick="tryItOut('GETapi-cars');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-cars"
                    onclick="cancelTryOut('GETapi-cars');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-cars"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/cars</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-cars"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-cars"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-GETapi-cars--car_id-">GET api/cars/{car_id}</h2>

<p>
</p>



<span id="example-requests-GETapi-cars--car_id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/cars/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/cars/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-cars--car_id-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;data&quot;: {
        &quot;id&quot;: 1,
        &quot;price&quot;: 65000,
        &quot;year&quot;: 2018,
        &quot;mileage&quot;: 410000,
        &quot;vin&quot;: &quot;DVG7XKCE6ZZBHPD7G&quot;,
        &quot;description&quot;: &quot;Consectetur a totam at aut quos. Ea maxime necessitatibus sit quis cupiditate explicabo. Aspernatur rerum fugit velit ipsum eveniet. Magni est inventore eveniet. Velit error saepe sit et ut. Porro ipsum dolor harum atque. Eum assumenda cupiditate facilis architecto nihil aut eum. Dolorem provident id non non. Rerum molestiae labore vel dolorem praesentium illo. Explicabo hic nihil vel possimus tenetur. Et explicabo ipsa similique iste numquam deleniti repellendus. Doloribus rem laborum dicta. Et perspiciatis praesentium corrupti cumque nam minima aut. Harum aliquam sit aut dolor modi laboriosam sapiente. Molestiae minus doloribus et excepturi et. Dolorem tempora aperiam tenetur libero vel qui. Nisi omnis nostrum debitis necessitatibus corporis sint. Repudiandae nihil nihil quia iste quisquam. Explicabo impedit minus est dicta iste velit. Rerum voluptatem dolore reprehenderit velit aut. Laudantium voluptates possimus dignissimos ea repellat officiis sapiente. Esse quam ab aut ut quidem ut. Adipisci aut aut non ipsam suscipit magnam. Beatae nobis velit et impedit quis. Vitae iure possimus facilis aspernatur libero distinctio. Quo id aut nam aut voluptas est. Ad aliquid sed aut. Quod libero eligendi commodi recusandae. Necessitatibus quibusdam ipsum consequatur ut. Est nostrum consequatur neque voluptatum qui. Ut voluptatem cum omnis quas maxime delectus sed. Impedit esse est reiciendis est. Nihil at ut consectetur ut expedita ut sit. Eveniet debitis veniam doloribus esse perspiciatis molestiae est. Earum eos quia perferendis nesciunt voluptas ut voluptatem perspiciatis. Qui aperiam sunt quis illum id. Labore dolorum dolore necessitatibus quam esse. Aut quod consectetur blanditiis quidem. Non voluptate dolorem non et est possimus ut. Minus quia iste facere suscipit culpa. Et ipsum laudantium et voluptate numquam debitis exercitationem. Fugit sunt dolores doloribus voluptas rem. Corrupti voluptatem rem veniam beatae ut.&quot;,
        &quot;published_at&quot;: &quot;2026-05-27 14:55:00&quot;,
        &quot;vehiculo&quot;: {
            &quot;maker&quot;: &quot;Toyota&quot;,
            &quot;model&quot;: &quot;Camry&quot;,
            &quot;car_type&quot;: &quot;Pickup Truck&quot;,
            &quot;fuel_type&quot;: &quot;Hybrid&quot;
        },
        &quot;contacto&quot;: {
            &quot;phone&quot;: &quot;1-805-638-9303&quot;,
            &quot;address&quot;: &quot;554 Virgie Turnpike\nBeierfort, NE 53930-1903&quot;,
            &quot;city&quot;: &quot;New York City&quot;
        },
        &quot;owner&quot;: {
            &quot;id&quot;: 4,
            &quot;name&quot;: &quot;Miss Beryl Volkman II&quot;,
            &quot;email&quot;: &quot;alysa52@example.net&quot;,
            &quot;phone&quot;: &quot;9099613374&quot;,
            &quot;rol&quot;: &quot;user&quot;,
            &quot;estadisticas&quot;: {
                &quot;total_coches&quot;: 50,
                &quot;total_favoritos&quot;: 0
            },
            &quot;created_at&quot;: &quot;2026-06-12&quot;
        },
        &quot;imagen_principal&quot;: &quot;https://loremflickr.com/800/600/car,toyota?lock=1&quot;,
        &quot;imagenes&quot;: [
            {
                &quot;id&quot;: 1,
                &quot;url&quot;: &quot;https://loremflickr.com/800/600/car?lock=510&quot;,
                &quot;position&quot;: 1
            },
            {
                &quot;id&quot;: 251,
                &quot;url&quot;: &quot;https://loremflickr.com/800/600/car,toyota?lock=1&quot;,
                &quot;position&quot;: 1
            },
            {
                &quot;id&quot;: 2,
                &quot;url&quot;: &quot;https://loremflickr.com/800/600/car?lock=378&quot;,
                &quot;position&quot;: 2
            },
            {
                &quot;id&quot;: 3,
                &quot;url&quot;: &quot;https://loremflickr.com/800/600/car?lock=630&quot;,
                &quot;position&quot;: 3
            },
            {
                &quot;id&quot;: 4,
                &quot;url&quot;: &quot;https://loremflickr.com/800/600/car?lock=837&quot;,
                &quot;position&quot;: 4
            },
            {
                &quot;id&quot;: 5,
                &quot;url&quot;: &quot;https://loremflickr.com/800/600/car?lock=983&quot;,
                &quot;position&quot;: 5
            }
        ],
        &quot;created_at&quot;: &quot;2026-06-12&quot;
    },
    &quot;meta&quot;: []
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-cars--car_id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-cars--car_id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-cars--car_id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-cars--car_id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-cars--car_id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-cars--car_id-" data-method="GET"
      data-path="api/cars/{car_id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-cars--car_id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-cars--car_id-"
                    onclick="tryItOut('GETapi-cars--car_id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-cars--car_id-"
                    onclick="cancelTryOut('GETapi-cars--car_id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-cars--car_id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/cars/{car_id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-cars--car_id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-cars--car_id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>car_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="car_id"                data-endpoint="GETapi-cars--car_id-"
               value="1"
               data-component="url">
    <br>
<p>The ID of the car. Example: <code>1</code></p>
            </div>
                    </form>

                    <h2 id="endpoints-GETapi-catalog-makers">GET api/catalog/makers</h2>

<p>
</p>



<span id="example-requests-GETapi-catalog-makers">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/catalog/makers" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/catalog/makers"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-catalog-makers">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;data&quot;: [
        {
            &quot;id&quot;: 2,
            &quot;name&quot;: &quot;Ford&quot;
        },
        {
            &quot;id&quot;: 1,
            &quot;name&quot;: &quot;Toyota&quot;
        }
    ],
    &quot;meta&quot;: {
        &quot;total&quot;: 2
    }
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-catalog-makers" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-catalog-makers"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-catalog-makers"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-catalog-makers" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-catalog-makers">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-catalog-makers" data-method="GET"
      data-path="api/catalog/makers"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-catalog-makers', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-catalog-makers"
                    onclick="tryItOut('GETapi-catalog-makers');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-catalog-makers"
                    onclick="cancelTryOut('GETapi-catalog-makers');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-catalog-makers"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/catalog/makers</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-catalog-makers"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-catalog-makers"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-GETapi-catalog-fuel-types">GET api/catalog/fuel-types</h2>

<p>
</p>



<span id="example-requests-GETapi-catalog-fuel-types">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/catalog/fuel-types" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/catalog/fuel-types"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-catalog-fuel-types">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;data&quot;: [
        {
            &quot;id&quot;: 1,
            &quot;name&quot;: &quot;Gasoline&quot;
        },
        {
            &quot;id&quot;: 2,
            &quot;name&quot;: &quot;Diesel&quot;
        },
        {
            &quot;id&quot;: 3,
            &quot;name&quot;: &quot;Electric&quot;
        },
        {
            &quot;id&quot;: 4,
            &quot;name&quot;: &quot;Hybrid&quot;
        }
    ],
    &quot;meta&quot;: {
        &quot;total&quot;: 4
    }
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-catalog-fuel-types" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-catalog-fuel-types"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-catalog-fuel-types"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-catalog-fuel-types" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-catalog-fuel-types">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-catalog-fuel-types" data-method="GET"
      data-path="api/catalog/fuel-types"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-catalog-fuel-types', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-catalog-fuel-types"
                    onclick="tryItOut('GETapi-catalog-fuel-types');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-catalog-fuel-types"
                    onclick="cancelTryOut('GETapi-catalog-fuel-types');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-catalog-fuel-types"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/catalog/fuel-types</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-catalog-fuel-types"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-catalog-fuel-types"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-GETapi-catalog-car-types">GET api/catalog/car-types</h2>

<p>
</p>



<span id="example-requests-GETapi-catalog-car-types">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/catalog/car-types" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/catalog/car-types"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-catalog-car-types">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;data&quot;: [
        {
            &quot;id&quot;: 1,
            &quot;name&quot;: &quot;Sedan&quot;
        },
        {
            &quot;id&quot;: 2,
            &quot;name&quot;: &quot;Hatchback&quot;
        },
        {
            &quot;id&quot;: 3,
            &quot;name&quot;: &quot;SUV&quot;
        },
        {
            &quot;id&quot;: 4,
            &quot;name&quot;: &quot;Pickup Truck&quot;
        },
        {
            &quot;id&quot;: 5,
            &quot;name&quot;: &quot;Minivan&quot;
        },
        {
            &quot;id&quot;: 6,
            &quot;name&quot;: &quot;Jeep&quot;
        },
        {
            &quot;id&quot;: 7,
            &quot;name&quot;: &quot;Coupe&quot;
        },
        {
            &quot;id&quot;: 8,
            &quot;name&quot;: &quot;Crossover&quot;
        },
        {
            &quot;id&quot;: 9,
            &quot;name&quot;: &quot;Sports Car&quot;
        }
    ],
    &quot;meta&quot;: {
        &quot;total&quot;: 9
    }
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-catalog-car-types" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-catalog-car-types"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-catalog-car-types"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-catalog-car-types" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-catalog-car-types">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-catalog-car-types" data-method="GET"
      data-path="api/catalog/car-types"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-catalog-car-types', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-catalog-car-types"
                    onclick="tryItOut('GETapi-catalog-car-types');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-catalog-car-types"
                    onclick="cancelTryOut('GETapi-catalog-car-types');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-catalog-car-types"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/catalog/car-types</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-catalog-car-types"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-catalog-car-types"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-GETapi-admin-users">GET api/admin/users</h2>

<p>
</p>



<span id="example-requests-GETapi-admin-users">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/admin/users" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/admin/users"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-admin-users">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Unauthenticated.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-admin-users" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-admin-users"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-admin-users"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-admin-users" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-admin-users">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-admin-users" data-method="GET"
      data-path="api/admin/users"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-admin-users', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-admin-users"
                    onclick="tryItOut('GETapi-admin-users');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-admin-users"
                    onclick="cancelTryOut('GETapi-admin-users');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-admin-users"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/admin/users</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-admin-users"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-admin-users"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-POSTapi-auth-logout">POST api/auth/logout</h2>

<p>
</p>



<span id="example-requests-POSTapi-auth-logout">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost/api/auth/logout" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/auth/logout"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "POST",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-auth-logout">
</span>
<span id="execution-results-POSTapi-auth-logout" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-auth-logout"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-auth-logout"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-auth-logout" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-auth-logout">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-auth-logout" data-method="POST"
      data-path="api/auth/logout"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-auth-logout', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-auth-logout"
                    onclick="tryItOut('POSTapi-auth-logout');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-auth-logout"
                    onclick="cancelTryOut('POSTapi-auth-logout');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-auth-logout"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/auth/logout</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-auth-logout"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-auth-logout"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-GETapi-auth-me">GET api/auth/me</h2>

<p>
</p>



<span id="example-requests-GETapi-auth-me">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/auth/me" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/auth/me"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-auth-me">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Unauthenticated.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-auth-me" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-auth-me"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-auth-me"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-auth-me" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-auth-me">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-auth-me" data-method="GET"
      data-path="api/auth/me"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-auth-me', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-auth-me"
                    onclick="tryItOut('GETapi-auth-me');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-auth-me"
                    onclick="cancelTryOut('GETapi-auth-me');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-auth-me"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/auth/me</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-auth-me"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-auth-me"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-GETapi-user-me">GET api/user/me</h2>

<p>
</p>



<span id="example-requests-GETapi-user-me">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/user/me" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/user/me"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-user-me">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Unauthenticated.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-user-me" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-user-me"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-user-me"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-user-me" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-user-me">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-user-me" data-method="GET"
      data-path="api/user/me"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-user-me', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-user-me"
                    onclick="tryItOut('GETapi-user-me');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-user-me"
                    onclick="cancelTryOut('GETapi-user-me');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-user-me"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/user/me</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-user-me"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-user-me"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-GETapi-user-favourites">GET api/user/favourites</h2>

<p>
</p>



<span id="example-requests-GETapi-user-favourites">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/user/favourites" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/user/favourites"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-user-favourites">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Unauthenticated.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-user-favourites" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-user-favourites"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-user-favourites"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-user-favourites" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-user-favourites">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-user-favourites" data-method="GET"
      data-path="api/user/favourites"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-user-favourites', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-user-favourites"
                    onclick="tryItOut('GETapi-user-favourites');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-user-favourites"
                    onclick="cancelTryOut('GETapi-user-favourites');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-user-favourites"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/user/favourites</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-user-favourites"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-user-favourites"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-POSTapi-cars">POST api/cars</h2>

<p>
</p>



<span id="example-requests-POSTapi-cars">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost/api/cars" \
    --header "Content-Type: multipart/form-data" \
    --header "Accept: application/json" \
    --form "maker_id=1"\
    --form "model_id=1"\
    --form "city_id=1"\
    --form "car_type_id=1"\
    --form "fuel_type_id=1"\
    --form "year=2020"\
    --form "price=15000"\
    --form "mileage=80000"\
    --form "vin=WVWZZZ1KZAW000001"\
    --form "phone=600123456"\
    --form "address=Calle Mayor 1"\
    --form "description=Coche en perfecto estado, único dueño."\
    --form "images[]=@C:\Users\TORTOSA\AppData\Local\Temp\php7C4A.tmp" </code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/cars"
);

const headers = {
    "Content-Type": "multipart/form-data",
    "Accept": "application/json",
};

const body = new FormData();
body.append('maker_id', '1');
body.append('model_id', '1');
body.append('city_id', '1');
body.append('car_type_id', '1');
body.append('fuel_type_id', '1');
body.append('year', '2020');
body.append('price', '15000');
body.append('mileage', '80000');
body.append('vin', 'WVWZZZ1KZAW000001');
body.append('phone', '600123456');
body.append('address', 'Calle Mayor 1');
body.append('description', 'Coche en perfecto estado, único dueño.');
body.append('images[]', document.querySelector('input[name="images[]"]').files[0]);

fetch(url, {
    method: "POST",
    headers,
    body,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-cars">
</span>
<span id="execution-results-POSTapi-cars" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-cars"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-cars"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-cars" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-cars">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-cars" data-method="POST"
      data-path="api/cars"
      data-authed="0"
      data-hasfiles="1"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-cars', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-cars"
                    onclick="tryItOut('POSTapi-cars');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-cars"
                    onclick="cancelTryOut('POSTapi-cars');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-cars"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/cars</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-cars"
               value="multipart/form-data"
               data-component="header">
    <br>
<p>Example: <code>multipart/form-data</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-cars"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>maker_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="maker_id"                data-endpoint="POSTapi-cars"
               value="1"
               data-component="body">
    <br>
<p>ID de la marca del coche. Must match an existing stored value. Example: <code>1</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>model_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="model_id"                data-endpoint="POSTapi-cars"
               value="1"
               data-component="body">
    <br>
<p>ID del modelo del coche. Must match an existing stored value. Example: <code>1</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>city_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="city_id"                data-endpoint="POSTapi-cars"
               value="1"
               data-component="body">
    <br>
<p>ID de la ciudad donde se ubica el coche. Must match an existing stored value. Example: <code>1</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>car_type_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="car_type_id"                data-endpoint="POSTapi-cars"
               value="1"
               data-component="body">
    <br>
<p>ID del tipo de carrocería. Must match an existing stored value. Example: <code>1</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>fuel_type_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="fuel_type_id"                data-endpoint="POSTapi-cars"
               value="1"
               data-component="body">
    <br>
<p>ID del tipo de combustible. Must match an existing stored value. Example: <code>1</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>year</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="year"                data-endpoint="POSTapi-cars"
               value="2020"
               data-component="body">
    <br>
<p>Año de fabricación. Must be at least 1900. Must not be greater than 2027. Example: <code>2020</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>price</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="price"                data-endpoint="POSTapi-cars"
               value="15000"
               data-component="body">
    <br>
<p>Precio del coche en euros. Must be at least 0. Example: <code>15000</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>mileage</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="mileage"                data-endpoint="POSTapi-cars"
               value="80000"
               data-component="body">
    <br>
<p>Kilometraje del coche. Must be at least 0. Example: <code>80000</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>vin</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="vin"                data-endpoint="POSTapi-cars"
               value="WVWZZZ1KZAW000001"
               data-component="body">
    <br>
<p>Número de bastidor (VIN). Must not be greater than 255 characters. Example: <code>WVWZZZ1KZAW000001</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>phone</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="phone"                data-endpoint="POSTapi-cars"
               value="600123456"
               data-component="body">
    <br>
<p>Teléfono de contacto del anuncio. Must not be greater than 45 characters. Example: <code>600123456</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>address</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="address"                data-endpoint="POSTapi-cars"
               value="Calle Mayor 1"
               data-component="body">
    <br>
<p>Dirección donde se puede ver el coche. Must not be greater than 255 characters. Example: <code>Calle Mayor 1</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>description</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="description"                data-endpoint="POSTapi-cars"
               value="Coche en perfecto estado, único dueño."
               data-component="body">
    <br>
<p>Descripción libre del anuncio. Example: <code>Coche en perfecto estado, único dueño.</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>images</code></b>&nbsp;&nbsp;
<small>file[]</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="file" style="display: none"
                              name="images[0]"                data-endpoint="POSTapi-cars"
               data-component="body">
        <input type="file" style="display: none"
               name="images[1]"                data-endpoint="POSTapi-cars"
               data-component="body">
    <br>
<p>Cada imagen: jpg, jpeg, png, gif o webp (máx. 5 MB). Must be an image. Must not be greater than 5120 kilobytes.</p>
        </div>
        </form>

                    <h2 id="endpoints-PUTapi-cars--car_id-">PUT api/cars/{car_id}</h2>

<p>
</p>



<span id="example-requests-PUTapi-cars--car_id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request PUT \
    "http://localhost/api/cars/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"maker_id\": 1,
    \"model_id\": 1,
    \"city_id\": 1,
    \"car_type_id\": 1,
    \"fuel_type_id\": 1,
    \"year\": 2020,
    \"price\": 15000,
    \"mileage\": 80000,
    \"vin\": \"WVWZZZ1KZAW000001\",
    \"phone\": \"600123456\",
    \"address\": \"Calle Mayor 1\",
    \"description\": \"Coche en perfecto estado, único dueño.\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/cars/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "maker_id": 1,
    "model_id": 1,
    "city_id": 1,
    "car_type_id": 1,
    "fuel_type_id": 1,
    "year": 2020,
    "price": 15000,
    "mileage": 80000,
    "vin": "WVWZZZ1KZAW000001",
    "phone": "600123456",
    "address": "Calle Mayor 1",
    "description": "Coche en perfecto estado, único dueño."
};

fetch(url, {
    method: "PUT",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-PUTapi-cars--car_id-">
</span>
<span id="execution-results-PUTapi-cars--car_id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-PUTapi-cars--car_id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-cars--car_id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-PUTapi-cars--car_id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-cars--car_id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-PUTapi-cars--car_id-" data-method="PUT"
      data-path="api/cars/{car_id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('PUTapi-cars--car_id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-PUTapi-cars--car_id-"
                    onclick="tryItOut('PUTapi-cars--car_id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-PUTapi-cars--car_id-"
                    onclick="cancelTryOut('PUTapi-cars--car_id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-PUTapi-cars--car_id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-darkblue">PUT</small>
            <b><code>api/cars/{car_id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="PUTapi-cars--car_id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="PUTapi-cars--car_id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>car_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="car_id"                data-endpoint="PUTapi-cars--car_id-"
               value="1"
               data-component="url">
    <br>
<p>The ID of the car. Example: <code>1</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>maker_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="maker_id"                data-endpoint="PUTapi-cars--car_id-"
               value="1"
               data-component="body">
    <br>
<p>ID de la marca del coche. Must match an existing stored value. Example: <code>1</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>model_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="model_id"                data-endpoint="PUTapi-cars--car_id-"
               value="1"
               data-component="body">
    <br>
<p>ID del modelo del coche. Must match an existing stored value. Example: <code>1</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>city_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="city_id"                data-endpoint="PUTapi-cars--car_id-"
               value="1"
               data-component="body">
    <br>
<p>ID de la ciudad donde se ubica el coche. Must match an existing stored value. Example: <code>1</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>car_type_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="car_type_id"                data-endpoint="PUTapi-cars--car_id-"
               value="1"
               data-component="body">
    <br>
<p>ID del tipo de carrocería. Must match an existing stored value. Example: <code>1</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>fuel_type_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="fuel_type_id"                data-endpoint="PUTapi-cars--car_id-"
               value="1"
               data-component="body">
    <br>
<p>ID del tipo de combustible. Must match an existing stored value. Example: <code>1</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>year</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="year"                data-endpoint="PUTapi-cars--car_id-"
               value="2020"
               data-component="body">
    <br>
<p>Año de fabricación. Must be at least 1900. Must not be greater than 2027. Example: <code>2020</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>price</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="price"                data-endpoint="PUTapi-cars--car_id-"
               value="15000"
               data-component="body">
    <br>
<p>Precio del coche en euros. Must be at least 0. Example: <code>15000</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>mileage</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="mileage"                data-endpoint="PUTapi-cars--car_id-"
               value="80000"
               data-component="body">
    <br>
<p>Kilometraje del coche. Must be at least 0. Example: <code>80000</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>vin</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="vin"                data-endpoint="PUTapi-cars--car_id-"
               value="WVWZZZ1KZAW000001"
               data-component="body">
    <br>
<p>Número de bastidor (VIN). Must not be greater than 255 characters. Example: <code>WVWZZZ1KZAW000001</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>phone</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="phone"                data-endpoint="PUTapi-cars--car_id-"
               value="600123456"
               data-component="body">
    <br>
<p>Teléfono de contacto del anuncio. Must not be greater than 45 characters. Example: <code>600123456</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>address</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="address"                data-endpoint="PUTapi-cars--car_id-"
               value="Calle Mayor 1"
               data-component="body">
    <br>
<p>Dirección donde se puede ver el coche. Must not be greater than 255 characters. Example: <code>Calle Mayor 1</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>description</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="description"                data-endpoint="PUTapi-cars--car_id-"
               value="Coche en perfecto estado, único dueño."
               data-component="body">
    <br>
<p>Descripción libre del anuncio. Example: <code>Coche en perfecto estado, único dueño.</code></p>
        </div>
        </form>

                    <h2 id="endpoints-DELETEapi-cars--car_id-">DELETE api/cars/{car_id}</h2>

<p>
</p>



<span id="example-requests-DELETEapi-cars--car_id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request DELETE \
    "http://localhost/api/cars/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/cars/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "DELETE",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-DELETEapi-cars--car_id-">
</span>
<span id="execution-results-DELETEapi-cars--car_id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-DELETEapi-cars--car_id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-cars--car_id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-DELETEapi-cars--car_id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-cars--car_id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-DELETEapi-cars--car_id-" data-method="DELETE"
      data-path="api/cars/{car_id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('DELETEapi-cars--car_id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-DELETEapi-cars--car_id-"
                    onclick="tryItOut('DELETEapi-cars--car_id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-DELETEapi-cars--car_id-"
                    onclick="cancelTryOut('DELETEapi-cars--car_id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-DELETEapi-cars--car_id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/cars/{car_id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="DELETEapi-cars--car_id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="DELETEapi-cars--car_id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>car_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="car_id"                data-endpoint="DELETEapi-cars--car_id-"
               value="1"
               data-component="url">
    <br>
<p>The ID of the car. Example: <code>1</code></p>
            </div>
                    </form>

                    <h2 id="endpoints-POSTapi-cars--car_id--favourite">POST api/cars/{car_id}/favourite</h2>

<p>
</p>



<span id="example-requests-POSTapi-cars--car_id--favourite">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost/api/cars/1/favourite" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/cars/1/favourite"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "POST",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-cars--car_id--favourite">
</span>
<span id="execution-results-POSTapi-cars--car_id--favourite" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-cars--car_id--favourite"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-cars--car_id--favourite"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-cars--car_id--favourite" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-cars--car_id--favourite">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-cars--car_id--favourite" data-method="POST"
      data-path="api/cars/{car_id}/favourite"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-cars--car_id--favourite', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-cars--car_id--favourite"
                    onclick="tryItOut('POSTapi-cars--car_id--favourite');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-cars--car_id--favourite"
                    onclick="cancelTryOut('POSTapi-cars--car_id--favourite');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-cars--car_id--favourite"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/cars/{car_id}/favourite</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-cars--car_id--favourite"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-cars--car_id--favourite"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>car_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="car_id"                data-endpoint="POSTapi-cars--car_id--favourite"
               value="1"
               data-component="url">
    <br>
<p>The ID of the car. Example: <code>1</code></p>
            </div>
                    </form>

                    <h2 id="endpoints-GETapi-favourites">GET api/favourites</h2>

<p>
</p>



<span id="example-requests-GETapi-favourites">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/favourites" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/favourites"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-favourites">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Unauthenticated.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-favourites" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-favourites"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-favourites"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-favourites" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-favourites">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-favourites" data-method="GET"
      data-path="api/favourites"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-favourites', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-favourites"
                    onclick="tryItOut('GETapi-favourites');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-favourites"
                    onclick="cancelTryOut('GETapi-favourites');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-favourites"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/favourites</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-favourites"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-favourites"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-GETapi-favourites--car_id-">GET api/favourites/{car_id}</h2>

<p>
</p>



<span id="example-requests-GETapi-favourites--car_id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/favourites/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/favourites/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-favourites--car_id-">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Unauthenticated.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-favourites--car_id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-favourites--car_id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-favourites--car_id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-favourites--car_id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-favourites--car_id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-favourites--car_id-" data-method="GET"
      data-path="api/favourites/{car_id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-favourites--car_id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-favourites--car_id-"
                    onclick="tryItOut('GETapi-favourites--car_id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-favourites--car_id-"
                    onclick="cancelTryOut('GETapi-favourites--car_id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-favourites--car_id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/favourites/{car_id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-favourites--car_id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-favourites--car_id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>car_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="car_id"                data-endpoint="GETapi-favourites--car_id-"
               value="1"
               data-component="url">
    <br>
<p>The ID of the car. Example: <code>1</code></p>
            </div>
                    </form>

                    <h2 id="endpoints-POSTapi-favourites--car_id-">POST api/favourites/{car_id}</h2>

<p>
</p>



<span id="example-requests-POSTapi-favourites--car_id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost/api/favourites/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"notes\": \"vmqeopfuudtdsufvyvddq\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/favourites/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "notes": "vmqeopfuudtdsufvyvddq"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-favourites--car_id-">
</span>
<span id="execution-results-POSTapi-favourites--car_id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-favourites--car_id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-favourites--car_id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-favourites--car_id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-favourites--car_id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-favourites--car_id-" data-method="POST"
      data-path="api/favourites/{car_id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-favourites--car_id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-favourites--car_id-"
                    onclick="tryItOut('POSTapi-favourites--car_id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-favourites--car_id-"
                    onclick="cancelTryOut('POSTapi-favourites--car_id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-favourites--car_id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/favourites/{car_id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-favourites--car_id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-favourites--car_id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>car_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="car_id"                data-endpoint="POSTapi-favourites--car_id-"
               value="1"
               data-component="url">
    <br>
<p>The ID of the car. Example: <code>1</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>notes</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="notes"                data-endpoint="POSTapi-favourites--car_id-"
               value="vmqeopfuudtdsufvyvddq"
               data-component="body">
    <br>
<p>Must not be greater than 500 characters. Example: <code>vmqeopfuudtdsufvyvddq</code></p>
        </div>
        </form>

                    <h2 id="endpoints-PUTapi-favourites--car_id-">PUT api/favourites/{car_id}</h2>

<p>
</p>



<span id="example-requests-PUTapi-favourites--car_id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request PUT \
    "http://localhost/api/favourites/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"notes\": \"vmqeopfuudtdsufvyvddq\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/favourites/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "notes": "vmqeopfuudtdsufvyvddq"
};

fetch(url, {
    method: "PUT",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-PUTapi-favourites--car_id-">
</span>
<span id="execution-results-PUTapi-favourites--car_id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-PUTapi-favourites--car_id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-favourites--car_id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-PUTapi-favourites--car_id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-favourites--car_id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-PUTapi-favourites--car_id-" data-method="PUT"
      data-path="api/favourites/{car_id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('PUTapi-favourites--car_id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-PUTapi-favourites--car_id-"
                    onclick="tryItOut('PUTapi-favourites--car_id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-PUTapi-favourites--car_id-"
                    onclick="cancelTryOut('PUTapi-favourites--car_id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-PUTapi-favourites--car_id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-darkblue">PUT</small>
            <b><code>api/favourites/{car_id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="PUTapi-favourites--car_id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="PUTapi-favourites--car_id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>car_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="car_id"                data-endpoint="PUTapi-favourites--car_id-"
               value="1"
               data-component="url">
    <br>
<p>The ID of the car. Example: <code>1</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>notes</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="notes"                data-endpoint="PUTapi-favourites--car_id-"
               value="vmqeopfuudtdsufvyvddq"
               data-component="body">
    <br>
<p>Must not be greater than 500 characters. Example: <code>vmqeopfuudtdsufvyvddq</code></p>
        </div>
        </form>

                    <h2 id="endpoints-DELETEapi-favourites--car_id-">DELETE api/favourites/{car_id}</h2>

<p>
</p>



<span id="example-requests-DELETEapi-favourites--car_id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request DELETE \
    "http://localhost/api/favourites/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/favourites/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "DELETE",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-DELETEapi-favourites--car_id-">
</span>
<span id="execution-results-DELETEapi-favourites--car_id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-DELETEapi-favourites--car_id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-favourites--car_id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-DELETEapi-favourites--car_id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-favourites--car_id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-DELETEapi-favourites--car_id-" data-method="DELETE"
      data-path="api/favourites/{car_id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('DELETEapi-favourites--car_id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-DELETEapi-favourites--car_id-"
                    onclick="tryItOut('DELETEapi-favourites--car_id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-DELETEapi-favourites--car_id-"
                    onclick="cancelTryOut('DELETEapi-favourites--car_id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-DELETEapi-favourites--car_id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/favourites/{car_id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="DELETEapi-favourites--car_id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="DELETEapi-favourites--car_id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>car_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="car_id"                data-endpoint="DELETEapi-favourites--car_id-"
               value="1"
               data-component="url">
    <br>
<p>The ID of the car. Example: <code>1</code></p>
            </div>
                    </form>

            

        
    </div>
    <div class="dark-box">
                    <div class="lang-selector">
                                                        <button type="button" class="lang-button" data-language-name="bash">bash</button>
                                                        <button type="button" class="lang-button" data-language-name="javascript">javascript</button>
                            </div>
            </div>
</div>
</body>
</html>
