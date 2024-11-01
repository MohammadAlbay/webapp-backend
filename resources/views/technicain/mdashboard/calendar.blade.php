<div id="reservation-cc" class="calender-container hide">
    <div class="head">
        <b>اختر اليوم من التقويم ادناه</b>
        <img onclick="Calendar.toggle()" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAACXBIWXMAAAsTAAALEwEAmpwYAAABN0lEQVR4nO3ZTWrDMBCG4fcoXfQkLZTuK83CSc6eRc8QAk0hJWBDMTFxJM1oLPRBdsYzj34S2YGenp6e1vIKhIr1w9hDVl6AI/ALHLCPABfgOwczIa7jxxojI2Kqn4yJY/PXGWaHfnYLtW89FRkVi5kRrZqWGNGuZYExGzDNQuZLWBQK1tiHxQtXQ5RsoDqiRCNuEDkNuUOkNOYW8UyD7hFrGt0M4tFhr9bhMyv3Rn8zM7EWsylEMxBpYWkNLWx2aeHrNy40uv93jXtMXIFwj4lPINxiYgLCHSZkINxgQgFEdUxYKJzzm2COCQoIc0xQRJhhAvBjdMQQLczXAuJ2ptKKlMbcW06XnFf7BZ40h5SbfQBnw5mYZz4zJ+A99WYTxhoxx2QhpnxW/jN0AN4q1u/p6emhfP4AxlR3VfJGRpkAAAAASUVORK5CYII=">
    </div>
    <div style="width: 100%; text-align: center; font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">
        <p>
            قم بتحديد تاريخ الحجز من الجدول ادناه. مع ضرورة مرعات ان الحجز مبدئي ويحتاج الى موافقة الفني اولا.
            عند موافقة الفني سوف تتلقى رسالة على بريدك الالكتروني تخبرك بتأكيد الحجز
        </p>
    </div>
    <div>
        <table class="calendar">
            <thead>
                <tr>
                    <th>Sun</th>
                    <th>Mon</th>
                    <th>Tue</th>
                    <th>Wed</th>
                    <th>Thu</th>
                    <th>Fri</th>
                    <th>Sat</th>
                </tr>
            </thead>
            <tbody>

                <!-- Add more rows as needed -->
            </tbody>
        </table>
    </div>

    <div onclick="Calendar.addReservation({{$me->id}})" class="ux-input2 btn primary" style="margin:0 auto; margin-top:1em">
    تأكيد
    </div>
</div>