
<!DOCTYPE html>
<html>
<header>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-uWxY/CJNBR+1zjPWmfnSnVxwRheevXITnMqoEIeG1LJrdI0GlVs/9cVSyPYXdcSF" crossorigin="anonymous">
</header>
<body>

<style>
    .title {
        font-family: aakar;
        font-style: italic;
        color: #0f3d8d;
    }
    .card{
        background-color: #F5F5F5;
        border: 1px solid #0a0a0a;
    }
    p{
        font-family: Apple;
        font-size: 18px;
    }
    @media print {
        #printCertificate {
            display: none;

        }
    }
</style>

<div class="container mt-5 ">
 <center>
    <div class="col-8 ">
        <div class="card"  >
            <div class="card-body">
                <h2 class="card-title text-center title" >Certificate of Course Completion</h2>
                <img src="{{url('/web/images/pscmitr-logo.png')}}" class="w-25 mx-auto d-block" alt="...">
                <p class="text-center font-sm  "> This is to certiify that <span style="font-weight: bolder"> {{ ucfirst($user->name)}}</span> successfully completed <span style="font-weight: bolder"> {{ ucfirst($package->name)}} </span>
                    pscmitr online course on  Date <span style="font-weight: bolder"> {{ \Carbon\Carbon::parse($testResult->created_at)->toDateString() }} </span>. </p>
                <div class="text-center">
                  <span class="font-xs text-black fw-700 ">Shijin</span><br>
                    <span class="font-xs text-black fw-700  ">Director</span>
                </div>
            </div>
        </div>
    </div>
     <Button id="printCertificate" class="btn btn-primary mt-5 btn-lg" onclick="window.print()"/>
            Print!
     </button>
    </center>
</div>
</body>
</html>







