<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>

    <link rel="stylesheet" href="/css/button.css">
    <link rel="stylesheet" href="/css/input.css">
    <link rel="stylesheet" href="/css/index.css">
    <link rel="stylesheet" href="/css/calendar.css">
    <link rel="stylesheet" href="/css/profile.css">


</head>

<body>
    @include("main.md-dash-nav-barmenu")
    <div class="md-container" style="overflow-y: auto;padding-top:0px">

        <div class="md-grid-container" style="overflow: auto;">

            <div class="md-grid-item full-width" style="background-color:green">
                <div class="profile-headblock">
                    <div class="cover" style="background-image: url('/imgs/cover.png')"></div>
                    <div class="pic" style="background-image: url('/imgs/catleft.jpg');">
                        <div class="pic-hover-content">
                            تغيير
                        </div>
                    </div>
                    <div class="name">محمد صلاح احمد اللبي</div>
                </div>

            </div>
            <div class="md-grid-item md-grid-container full-width" dir="rtl" style="background: transparent; border:none;">
                <div class="md-grid-item half-width" style="border-radius: 1em;">
                    <b class="title">مركز التنبيهات</b>
                    <div>Not yet</div>
                </div>
                <div class="md-grid-item half-width" style="border-radius: 1em;">
                    <b class="title">جدول الاعمال الحالي</b>
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
                                <tr>
                                    <td>1</td>
                                    <td>2</td>
                                    <td>3</td>
                                    <td>4</td>
                                    <td>5</td>
                                    <td>6</td>
                                    <td>7</td>
                                </tr>
                                <tr>
                                    <td>8</td>
                                    <td>9</td>
                                    <td>10</td>
                                    <td>11</td>
                                    <td>12</td>
                                    <td>13</td>
                                    <td>14</td>
                                </tr>
                                <tr>
                                    <td>15</td>
                                    <td>16</td>
                                    <td>17</td>
                                    <td>18</td>
                                    <td>19</td>
                                    <td>20</td>
                                    <td>21</td>
                                </tr>
                                <tr>
                                    <td>22</td>
                                    <td>23</td>
                                    <td>24</td>
                                    <td>25</td>
                                    <td>26</td>
                                    <td>27</td>
                                    <td>28</td>
                                </tr>
                                <tr>
                                    <td>29</td>
                                    <td>30</td>
                                    <td>31</td>
                                    <td>1</td>
                                    <td>2</td>
                                    <td>3</td>
                                    <td>4</td>
                                </tr>
                                <!-- Add more rows as needed -->
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="md-grid-item half-width" style="border-radius: 1em;">
                    <b class="title">بياناتك الشخصية</b>
                    <div>
                        <form id="form_technicain_edit" action="/technicain/edit" method="post" enctype='application/x-www-form-urlencoded'>
                            <div class="ux-input2">
                                <img src="https://img.icons8.com/?size=100&id=19949&format=png&color=000000" alt="">
                                <label for="technicain_field_name">اسم الفني</label>
                                <input type="text" id="technicain_field_name" name="technicain_field_name" placeholder="" form="form_technicain_edit">
                            </div>
                            <div class="ux-input2">
                                <img src="https://img.icons8.com/?size=100&id=19949&format=png&color=000000" alt="">
                                <label for="technicain_field_password">كلمة المرور</label>
                                <input type="password" id="technicain_field_password" name="technicain_field_password" placeholder="" form="form_technicain_edit">
                            </div>
                            <div class="ux-input2">
                                <img src="https://img.icons8.com/?size=100&id=19949&format=png&color=000000" alt="">
                                <label for="technicain_field_address">العنوان</label>
                                <input type="text" id="technicain_field_address" name="technicain_field_address" placeholder="" form="form_technicain_edit">
                            </div>
                            <div class="ux-input2">
                                <img src="https://img.icons8.com/?size=100&id=19949&format=png&color=000000" alt="">
                                <label for="technicain_field_phone">رقم الهاتف</label>
                                <input type="text" id="technicain_field_phone" name="technicain_field_phone" placeholder="" form="form_technicain_edit">
                            </div>
                            <div class="ux-input2">
                                <img src="https://img.icons8.com/?size=100&id=19949&format=png&color=000000" alt="">
                                <label for="technicain_field_birthdate">تاريخ الميلاد</label>
                                <input type="date" id="technicain_field_birthdate" name="technicain_field_birthdate" placeholder="" form="form_technicain_edit">
                            </div>
                    </div>
                </div>

            </div>

        </div>


        <script src="/js/index.js"></script>
        <script>
            document.getElementById('view_posts').addEventListener('click', e => {
                e.stopPropagation();
                alert('ff');
            });
        </script>
</body>

</html>