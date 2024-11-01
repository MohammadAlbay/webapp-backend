<!-- For Regular tasks -->
@if(session('task-complet'))
@if(session('task-complet') == true)
<script>
    setTimeout(() => {
        Swal.fire({
        toast: true,
        icon: "success",
        title: 'اكتملت العملية',
        text: "{{session('task-complet')}}",
        position: "top-end",
        showConfirmButton: false,
        timer: 2000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
        },

        didClose: () => {
            location.reload();
        }
    });
    }, 900);
</script>
@endif
@endif