<dialog id="rate_dialog" class="flex-dialog hide" open>
    <img onclick="RateProcessor.hide(rate_dialog);" class="close-icon" src="https://img.icons8.com/?size=100&id=46&format=png&color=000000" alt="">
    <div class="logo-text arabic-text">
        <b class="black-text text">فني</b>
        <b class="green-text text">لعندك</b>
    </div>
    <h5 class="description">قيم الفني</h5>

    <div class="stars-container">
        <img star-value="1" src="/rahma-ui/storage/images/icons8-star-48_uncolored.png" alt="">
        <img star-value="2" src="/rahma-ui/storage/images/icons8-star-48_uncolored.png" alt="">
        <img star-value="3" src="/rahma-ui/storage/images/icons8-star-48_uncolored.png" alt="">
        <img star-value="4" src="/rahma-ui/storage/images/icons8-star-48_uncolored.png" alt="">
        <img star-value="5" src="/rahma-ui/storage/images/icons8-star-48_uncolored.png" alt="">
    </div>

    <button class="bottom-button" onclick="RateProcessor.saveRate({{$me->id}})">تقييم</button>
</dialog>