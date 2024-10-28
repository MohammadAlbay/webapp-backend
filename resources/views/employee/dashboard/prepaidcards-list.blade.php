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
        <h3 class="page-title">بطاقات الدفع المسجلة </h3>
    </div>

    <div class="d-flex grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title"></h4>
                <p class="card-description">قم بتحديد الكمية والفئة السعرية فالنوذج التالي</p>


                <div id="accordion">
                    @foreach ($prepaidcardGenerations as $generation)
                    @php
                    $cardsList = \App\Models\PrepaidCard::getGenerationModelList($generation->Date, $generation->Category);
                    $accordionRowId = str_replace(' ', '-', $generation->row_num);

                    // we need to get array of cards ids to make 'print all' and 'cancel all' functionality
                    // available and possible
                    $cardsIdArray = [];
                    foreach($cardsList as $c) {
                    if($c->state != 'Active') continue;
                    array_push($cardsIdArray,
                    [
                    "id" => $c->id,
                    "serial" => $c->serial,
                    "price" => $c->money,
                    ]);
                    }

                    @endphp

                    <div class="card">
                        <div class="card-header" id="heading{{$accordionRowId}}">
                            <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$accordionRowId}}" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                                    {{$generation->row_num}}({{$generation->Generated}} items)
                                </button>
                            </h2>
                        </div>

                        <div id="collapse{{$accordionRowId}}" class="accordion-collapse collapse" aria-labelledby="heading{{$accordionRowId}}" data-parent="#accordion">
                            <div class="card-body">


                                @if($cardsList->count() > 0)
                                @if($me->hasPermission(\App\Models\Permission::PERMISSION_PRINT_PREPAIDCARDS_NAME))
                                <button class="btn btn-primary" {{count($cardsIdArray) == 0 ? 'disabled' : ''}} onclick='printCardProcessor(@json($cardsIdArray))'>طباعة الكل</button>
                                @endif
                                @if($me->hasPermission(\App\Models\Permission::PERMISSION_MODIFY_PREPAIDCARDS_NAME))
                                <button class="btn btn-danger" {{count($cardsIdArray) == 0 ? 'disabled' : ''}} onclick='switchPrepaidcard(@json($cardsIdArray))'>الغاء الكل</button>
                                @endif
                                <table>
                                    <tr>
                                        <td>#</td>
                                        <td>الرقم التسلسلي</td>
                                        <td>السعر</td>
                                        <td>الحالة</td>
                                        <td>-</td>
                                        <td>-</td>
                                    </tr>
                                    @foreach ($cardsList as $card)
                                    @php
                                    $stateSwtch = $card->state == 'Active' ? 'Cancled' : 'Active';
                                    $cardInfo = ['serial' => $card->serial, 'price' => $card->money];
                                    //Active,Used, Cancled
                                    @endphp
                                    <tr>
                                        <td>{{$card->id}}</td>
                                        <td>{{$card->serial}}</td>
                                        <td>{{$card->money}}</td>
                                        <td>
                                            @if($card->state == 'Used' &&
                                            !$me->hasPermission(\App\Models\Permission::PERMISSION_PREPAIDCARDS_HISTORY_NAME))
                                                غير مفعل
                                            @else
                                            {{$card->state == 'Active' ? 'مفعل' : ($card->state == 'Used' ? 'تمت التعبئة' : 'ملغي')}}
                                            @endif
                                        </td>
                                        <td>
                                            @if($me->hasPermission(\App\Models\Permission::PERMISSION_MODIFY_PREPAIDCARDS_NAME))
                                            <button type="button" class="btn {{$stateSwtch == 'Active' ? 'btn-secondary' : 'btn-danger' }}"
                                                style="color: white;"
                                                {{$stateSwtch == 'Active' ? 'disabled' : ''}}
                                                onclick="switchPrepaidcard('{{$card->id}}')">
                                                {{$stateSwtch == 'Active'? "تفعيل" : "الغاء"}}
                                            </button>
                                            @else
                                            🚫
                                            @endif
                                        </td>
                                        <td>
                                            @if($me->hasPermission(\App\Models\Permission::PERMISSION_PRINT_PREPAIDCARDS_NAME))
                                            <button type="button"
                                                class="btn {{$card->state == 'Active' ?  'btn-primary' : 'btn-secondary'}}"
                                                {{$card->state !== 'Active' ? 'disabled' : ''}}
                                                onclick='printCardProcessor([@json($cardInfo)])'>
                                                طباعة
                                            </button>
                                            @else
                                            🚫
                                            @endif

                                        </td>
                                    </tr>

                                    @endforeach
                                </table>
                                @else
                                <h5>No prepaidcards in generation?</h5>
                                @endif
                                </table>
                            </div>
                        </div>
                    </div>
                    @endforeach


                </div>

            </div>
        </div>
    </div>

    <script src="/sources/employee/js/index.js"></script>
    <script src="/sources/employee/js/printcard.js"></script>
    <script>
        async function printCardProcessor(param) {
            if (Array.isArray(param)) {
                // handle multiple values (from array)
                printCards(param);
                console.log(param);
            } else {
                // singular value

            }
        }

        async function switchPrepaidcard(ids) {
            Swal.fire({
                icon: "question",
                title: "هل انت متأكد من رغبتك في الغاء هذه البطاقة/البطاقات؟ لا يمكن الرجوع هن هذا الاجراء",
                showConfirmButton: true,
                showCancelButton: true,
            }).then(async result => {
                if (result.isConfirmed) {
                    if (Array.isArray(ids)) {
                        ids.forEach(async item => await disabledCard(item.id, true));
                        Swal.fire({
                            icon: "success",
                            title: "تم الغاء كل الكروت ",
                            showConfirmButton: true,
                        }).then((result) => ViewFetch.Load('prepaidcards-list'));
                    } else {
                        await disabledCard(ids);
                    }
                }
            });

        }

        async function disabledCard(id, quite = false) {
            await sendFormData('/prepaidcards/deactivate/' + id, 'GET', {}, v => {
                if (v.State == 1) {
                    Swal.fire({
                        icon: "error",
                        title: v.Message,
                        showConfirmButton: true,
                    });
                } else {
                    if (!quite) {
                        Swal.fire({
                            icon: "success",
                            title: v.Message,
                            showConfirmButton: true,
                        }).then((result) => ViewFetch.Load('prepaidcards-list'));
                    }

                }
            });
        }

        // async function generateNewCardsProcessor(self) {
        //     self.disabled = true;

        //     Swal.fire({
        //         title: "هل انت متأكد?",
        //         text: "هل انت متأكد انك تريد توليد دفعة جديدة من الكروت؟  ",
        //         icon: "warning",
        //         showCancelButton: true,
        //         confirmButtonColor: "#3085d6",
        //         cancelButtonColor: "#d33",
        //         cancelButtonText: "الغاء",
        //         confirmButtonText: "موافق"
        //     }).then(async (result) => {
        //         if (result.isConfirmed)
        //             await requestGenerate(self);

        //     });
        // }

        // async function requestGenerate(self) {
        //     let values = {
        //         quantity: generate_card_quantity.value,
        //         price: generate_card_price.value
        //     };

        //     if (values.quantity > 100 || values.quantity < 1) {
        //         Swal.fire({
        //             icon: "error",
        //             title: 'لا يمكن ان تكون الكمية اكثر من 100 او اقل من 1',
        //             showConfirmButton: true,
        //         });
        //         self.disabled = false;
        //         return;
        //     }
        //     await sendFormData('/prepaidcards/generate/' + values.quantity + '/' + values.price, 'GET', {}, v => {
        //         if (v.State == 1) {
        //             Swal.fire({
        //                 icon: "error",
        //                 title: v.Message,
        //                 showConfirmButton: true,
        //             });
        //             self.disabled = false;
        //         } else {
        //             Swal.fire({
        //                 icon: "success",
        //                 title: "تم توليد الكروت بنجاح",
        //                 showConfirmButton: true,
        //                 showDenyButton: true,
        //                 denyButtonText: `طباعة الكروت`,
        //                 confirmButtonText: `تم`
        //             }).then((result) => {
        //                 if (result.isConfirmed)
        //                     ViewFetch.Load('generate-cards')
        //                 else if (result.isDenied)
        //                     printCards(v.Message);
        //             });

        //             setTimeout(() => {
        //                 self.disabled = false
        //             }, 5000);
        //         }
        //     });
        // }
    </script>


</body>

</html>