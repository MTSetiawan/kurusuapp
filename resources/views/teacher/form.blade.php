{{-- Proxy for TeacherProfileController@edit --}}
@include('teacher.profile', ['user' => auth()->user(), 'profile' => $profile ?? null])
