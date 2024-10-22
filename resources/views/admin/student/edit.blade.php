

    <div class="tw-flex tw-items-center tw-justify-between tw-my-4">
        <h3>Edit student </h3>
    </div>
    <form method="POST" action="{{ route('student.edit', $student->student_id) }}" enctype="multipart/form-data" class="w-full max-w-md mx-auto">
        @csrf
        <div class="tw-mb-4">
            <label for="name" class="tw-block tw-text-gray-700">Name</label>
            <input value="{{ $student->name }}" type="text" name="name" id="name" placeholder="Name" required
                class="tw-w-full tw-px-3 tw-py-4 tw-leading-tight tw-border tw-rounded tw-shadow tw-appearance-none tw-focus:outline-none tw-focus:shadow-outline">
            @if ($errors->has('name'))
                <span class="tw-text-red-500">{{ $errors->first('name') }}</span>
            @endif
        </div>
        <div class="tw-mb-4">
            <label for="class" class="tw-block tw-text-gray-700">Class</label>
            <input value="{{ $student->class }}" type="text" name="class" id="class" placeholder="Class" required
                class="tw-w-full tw-px-3 tw-py-4 tw-leading-tight tw-border tw-rounded tw-shadow tw-appearance-none tw-focus:outline-none tw-focus:shadow-outline">
            @if ($errors->has('class'))
                <span class="tw-text-red-500">{{ $errors->first('class') }}</span>
            @endif
        </div>
        <div class="tw-mb-4">
            <label for="date_of_birth" class="tw-block tw-text-gray-700">Date of Birth</label>
            <input value="{{ $student->date_of_birth }}" type="date" name="date_of_birth" id="date_of_birth" required
                class="tw-w-full tw-px-3 tw-py-4 tw-leading-tight tw-border tw-rounded tw-shadow tw-appearance-none tw-focus:outline-none tw-focus:shadow-outline">
            @if ($errors->has('date_of_birth'))
                <span class="tw-text-red-500">{{ $errors->first('date_of_birth') }}</span>
            @endif
        </div>
        <div class="tw-mb-4">
            <label for="gender" class="tw-block tw-text-gray-700">Gender</label>
            <select name="gender" id="gender" required
                    class="tw-w-full tw-px-3 tw-py-4 tw-leading-tight tw-rounded tw-shadow tw-appearance-none tw-focus:outline-none tw-focus:shadow-outline">
               
                <option value="Nam" {{ $student->gender === 'Nam' ? 'selected' : '' }}>Nam</option>
                <option value="Nữ" {{ $student->gender === 'Nữ' ? 'selected' : '' }}>Nữ</option>
            </select>
            @if ($errors->has('gender'))
                <span class="tw-text-red-500">{{ $errors->first('gender') }}</span>
            @endif
        </div>
        <div class="tw-mb-4">
            <label for="person_id" class="tw-block tw-text-gray-700">Person ID</label>
            <input value="{{ $student->person_id }}" type="text" name="person_id" id="person_id" placeholder="Person ID" required
                class="tw-w-full tw-px-3 tw-py-4 tw-leading-tight tw-border tw-rounded tw-shadow tw-appearance-none tw-focus:outline-none tw-focus:shadow-outline">
            @if ($errors->has('person_id'))
                <span class="tw-text-red-500">{{ $errors->first('person_id') }}</span>
            @endif
        </div>
        <div class="tw-mb-4">
            <label for="phone_number" class="tw-block tw-text-gray-700">Phone Number</label>
            <input value="{{$student->phone_number}}" type="text" name="phone_number" id="phone_number" placeholder="Phone Number" required
                class="tw-w-full tw-px-3 tw-py-4 tw-leading-tight tw-border tw-rounded tw-shadow tw-appearance-none tw-focus:outline-none tw-focus:shadow-outline">
            @if ($errors->has('phone_number'))
                <span class="tw-text-red-500">{{ $errors->first('phone_number') }}</span>
            @endif
        </div>
        <div class="tw-mb-4">
            <label for="avatar" class="tw-block tw-text-gray-700">Avatar</label>
            <div class="tw-flex tw-items-cente  r tw-justify-between">
                @if ($student->avatar)
                    <img src="{{ asset('uploads/avatars/' . $student->avatar) }}" alt="avatar" class="tw-w-[80px] tw-h-[80px] tw-rounded-full tw-me-3 tw-mb-4">
                @endif
                
                <input type="file" name="avatar" id="avatar" placeholder="Avatar"
                    class="tw-w-full tw-px-3 tw-py-4 tw-leading-tight tw-border tw-rounded tw-shadow tw-appearance-none tw-focus:outline-none tw-focus:shadow-outline">
            </div>
            
        </div>
        
        <button type="submit"
            class="tw-w-full tw-px-4 tw-py-4 tw-mt-4 tw-text-white tw-bg-[#1ab394] tw-rounded-md  tw-focus:outline-none">
            Edit Student
        </button>
    </form>
