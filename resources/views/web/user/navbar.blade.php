<div class="profil-info">
    <div class="box-img">
        <div class="uplode">
            <div class="file-upload ">
                <label for="upload" class="file-upload__label">
                    <img class="img-fluid"
                         src="{{ url( $user->image ? $user->image : 'assets/img/avatar.png') }}"
                         alt="" id="blah">
                    <img class="cam" src="{{ url('assets/img') }}/Icons/camera_gray.png">
                </label>

            </div>
        </div>

    </div>
    <div class="box-inform text-center">
        <span>{{$user->first_name}} {{$user->last_name}}</span>
        <span>القاهرة</span>
        <span>{{$user->email}}</span>
    </div>
