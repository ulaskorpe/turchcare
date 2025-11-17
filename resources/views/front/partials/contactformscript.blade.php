
<script>
function validateEmail(email) {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
}
    $('#contact-form-x').submit(function(e) {
                e.preventDefault();
                var error = false;


                if ($('#name').val() == '') {

    $('#name').focus();
    Swal.fire({
        icon: 'error',
        text: "{{__('front.enter_name')}}"
    });

    error = true;
    return false;
    }

    if ($('#surname').val() == '') {

    $('#surname').focus();
    Swal.fire({
        icon: 'error',
        text: "{{__('front.enter_surname')}}"
    });

    error = true;
    return false;
    }

                if ($('#email').val() == '') {
                    $('#email').focus();
                    Swal.fire({
                        icon: 'error',
                        text: "{{__('front.enter_email')}}"
                    });
                    error = true;
                    return false;
                 }else{
                    if (!validateEmail($('#email').val())) {
                        $('#email').focus();
                        $('#email').val('');
                    Swal.fire({
                        icon: 'error',
                        text: "{{__('front.email_not_valid')}}"
                    });
                    error = true;
                    return false;
                    }

                 }


    if ($('#message').val() == '') {

    $('#message').focus();
    Swal.fire({
        icon: 'error',
        text: "{{__('front.enter_message')}}"
    });

    error = true;
    return false;
    }

                if (error) {
                    return false;
                }

                //function save(formData,route,formID,btn,reload) {
                var formData = new FormData(this);
                @if(empty($return_link))
                save(formData,'{{ route('contact-post') }}','contact-form-x','','/');
                @else
                save(formData,'{{ route('contact-post') }}','contact-form-x','','1');
                @endif

            });
    </script>