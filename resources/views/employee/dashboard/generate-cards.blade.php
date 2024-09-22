<?php

use Illuminate\Support\Facades\Auth;

$me = Auth::guard('employee')->user();
$myId = $me->id;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/sources/main.css">
    <link rel="stylesheet" href="/sources/employee/css/printcard.css">
    
    <title>Generate cards</title>
</head>

<body>
    <div class="page-header">
        <h3 class="page-title">توليد كروت جديدة </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/employee">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Employee</li>
            </ol>
        </nav>
    </div>

    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title"></h4>
                <p class="card-description">قم بتحديد الكمية والفئة السعرية فالنوذج التالي</p>
                <form id="generate-cards-form1" method="post" enctype="multipart/form-data" onsubmit="event.preventDefault();" action="{{route('signup.create')}}" class="forms-sample">
                    @csrf
                    <div class="form-group row">
                        <label for="generate_card_quantity" class="col-sm-3 col-form-label">الكمية</label>
                        <div class="col-sm-9">
                            <input type="number" step="1" min="1" max="100" class="form-control" id="generate_card_quantity" name="generate_card_quantity" placeholder="الكمية">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="generate_card_price" class="col-sm-3 col-form-label">الفئة السعرية</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="generate_card_price" name="generate_card_price">
                                @foreach ([5,10,20,30,50,100] as $price)
                                <option value="{{$price}}">{{ $price }} LYD</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary mr-2"
                        onclick="generateNewCardsProcessor(this);">توليد كروت جديدة</button>
                </form>
            </div>
        </div>
    </div>
    
    <script src="/sources/employee/js/index.js"></script>
    
    <script>
        async function generateNewCardsProcessor(self) {
            self.disabled = true;

            Swal.fire({
                title: "هل انت متأكد?",
                text: "هل انت متأكد انك تريد توليد دفعة جديدة من الكروت؟  ",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                cancelButtonText: "الغاء",
                confirmButtonText: "موافق"
            }).then(async (result) => {
                if (result.isConfirmed)
                    await requestGenerate(self);

            });
        }

        async function requestGenerate(self) {
            let values = {
                quantity: generate_card_quantity.value,
                price: generate_card_price.value
            };

            if(values.quantity > 100 || values.quantity < 1) {
                Swal.fire({
                        icon: "error",
                        title: 'لا يمكن ان تكون الكمية اكثر من 100 او اقل من 1',
                        showConfirmButton: true,
                });
                self.disabled = false;
                return;
            }
            await sendFormData('/prepaidcards/generate/' + values.quantity+'/'+values.price, 'GET', {}, v => {
                if (v.State == 1) {
                    Swal.fire({
                        icon: "error",
                        title: v.Message,
                        showConfirmButton: true,
                    });
                    self.disabled = false;
                } else {
                    Swal.fire({
                        icon: "success",
                        title: "تم توليد الكروت بنجاح",
                        showConfirmButton: true,
                        showDenyButton: true,
                        denyButtonText: `طباعة الكروت`,
                        confirmButtonText: `تم`
                    }).then((result) => {
                        if(result.isConfirmed) 
                            ViewFetch.Load('generate -cards')
                        else if(result.isDenied) 
                            printCards(v.Message);
                    });

                    setTimeout(() => {self.disabled = false}, 5000);
                }
            });
        }

    </script>
</body>

</html>