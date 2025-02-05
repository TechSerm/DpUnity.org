<div class="bg-white shadow-md rounded-lg p-8 space-y-6">
    <div class="grid md:grid-cols-2 gap-6">
        @if ($member && $member->organization_id != '')
            <div class="mb-4">
                <label for="organization_id" class="block text-sm font-medium text-gray-700 mb-2">আইডি</label>
                <input 
                    type="text" 
                    name="organization_id" 
                    id="organization_id" 
                    value="{{ $member->organization_id ?? '' }}"
                    placeholder="আইডি" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 transition duration-300"
                    {{ $member ? 'disabled' : '' }}
                >
            </div>
        @endif

        <div class="mb-4">
            <label for="category" class="block text-sm font-medium text-gray-700 mb-2">ক্যাটেগরি</label>
            <select 
                name="category" 
                id="category" 
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 transition duration-300"
                {{ $member ? 'disabled' : 'required' }}
            >
                <option value="">-- ক্যাটেগরি নির্বাচন করুন --</option>
                <option value="soddosho" {{ old('category', $member?->category) == 'soddosho' ? 'selected' : '' }}>সদস্য</option>
                <option value="data_soddosho" {{ old('category', $member?->category) == 'data_soddosho' ? 'selected' : '' }}>দাতা সদস্য</option>
                <option value="shohojoddha" {{ old('category', $member?->category) == 'shohojoddha' ? 'selected' : '' }}>সহযোদ্ধা</option>
                <option value="shuvokankkhi" {{ old('category', $member?->category) == 'shuvokankkhi' ? 'selected' : '' }}>শুভাকাঙ্ক্ষী</option>
            </select>
        </div>
    </div>

    <div class="grid md:grid-cols-2 gap-6">
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">নাম</label>
            <input 
                type="text" 
                name="name" 
                id="name" 
                value="{{ old('name', $member?->name) }}"
                placeholder="নাম" 
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 transition duration-300"
                {{ $member ? 'disabled' : 'required' }}
            >
        </div>

        <div class="mb-4">
            <label for="father_name" class="block text-sm font-medium text-gray-700 mb-2">পিতার নাম</label>
            <input 
                type="text" 
                name="father_name" 
                id="father_name" 
                value="{{ old('father_name', $member?->father_name) }}"
                placeholder="পিতার নাম" 
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 transition duration-300"
                {{ $member ? 'disabled' : 'required' }}
            >
        </div>
    </div>

    <div class="grid md:grid-cols-3 gap-6">
        <div class="mb-4">
            <label for="date_of_birth" class="block text-sm font-medium text-gray-700 mb-2">জন্ম তারিখ</label>
            <input 
                type="date" 
                name="date_of_birth" 
                id="date_of_birth" 
                value="{{ old('date_of_birth', $member?->date_of_birth?->format('Y-m-d')) }}"
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 transition duration-300"
                {{ $member ? 'disabled' : 'required' }}
            >
        </div>

        <div class="mb-4">
            <label for="nationality" class="block text-sm font-medium text-gray-700 mb-2">জাতীয়তা</label>
            <select 
                name="nationality" 
                id="nationality" 
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 transition duration-300"
                {{ $member ? 'disabled' : 'required' }}
            >
                <option value="">-- জাতীয়তা নির্বাচন করুন --</option>
                <option value="Bangladeshi" {{ old('nationality', $member?->nationality) == 'Bangladeshi' ? 'selected' : '' }}>বাংলাদেশী</option>
                <option value="Indian" {{ old('nationality', $member?->nationality) == 'Indian' ? 'selected' : '' }}>ভারতীয়</option>
                <option value="Other" {{ old('nationality', $member?->nationality) == 'Other' ? 'selected' : '' }}>অন্যান্য</option>
            </select>
        </div>

        <div class="mb-4">
            <label for="religion" class="block text-sm font-medium text-gray-700 mb-2">ধর্ম</label>
            <select 
                name="religion" 
                id="religion" 
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 transition duration-300"
                {{ $member ? 'disabled' : 'required' }}
            >
                <option value="">-- ধর্ম নির্বাচন করুন --</option>
                <option value="Islam" {{ old('religion', $member?->religion) == 'Islam' ? 'selected' : '' }}>ইসলাম</option>
                <option value="Hinduism" {{ old('religion', $member?->religion) == 'Hinduism' ? 'selected' : '' }}>হিন্দু ধর্ম</option>
                <option value="Other" {{ old('religion', $member?->religion) == 'Other' ? 'selected' : '' }}>অন্যান্য</option>
            </select>
        </div>
    </div>

    <div class="grid md:grid-cols-2 gap-6">
        <div class="mb-4">
            <label for="present_address" class="block text-sm font-medium text-gray-700 mb-2">বর্তমান ঠিকানা</label>
            <textarea 
                name="present_address" 
                id="present_address" 
                rows="3"
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 transition duration-300"
                {{ $member ? 'disabled' : 'required' }}
            >{{ old('present_address', $member?->present_address) }}</textarea>
        </div>

        <div class="mb-4">
            <label for="permanent_address" class="block text-sm font-medium text-gray-700 mb-2">স্থায়ী ঠিকানা</label>
            <textarea 
                name="permanent_address" 
                id="permanent_address" 
                rows="3"
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 transition duration-300"
                {{ $member ? 'disabled' : 'required' }}
            >{{ old('permanent_address', $member?->permanent_address) }}</textarea>
        </div>
    </div>

    <div class="grid md:grid-cols-2 gap-6">
        <div class="mb-4">
            <label for="mobile" class="block text-sm font-medium text-gray-700 mb-2">মোবাইল নম্বর</label>
            <input 
                type="tel" 
                name="mobile" 
                id="mobile" 
                value="{{ old('mobile', $member?->mobile) }}"
                placeholder="মোবাইল নম্বর" 
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 transition duration-300"
                {{ $member ? 'disabled' : 'required' }}
            >
        </div>

        <div class="mb-4">
            <label for="blood_group" class="block text-sm font-medium text-gray-700 mb-2">রক্তের গ্রুপ</label>
            <select 
                name="blood_group" 
                id="blood_group" 
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 transition duration-300"
            >
                <option value="">রক্তের গ্রুপ নির্বাচন করুন</option>
                <option value="A+" {{ old('blood_group', $member?->blood_group) == 'A+' ? 'selected' : '' }}>A+</option>
                <option value="A-" {{ old('blood_group', $member?->blood_group) == 'A-' ? 'selected' : '' }}>A-</option>
                <option value="B+" {{ old('blood_group', $member?->blood_group) == 'B+' ? 'selected' : '' }}>B+</option>
                <option value="B-" {{ old('blood_group', $member?->blood_group) == 'B-' ? 'selected' : '' }}>B-</option>
                <option value="AB+" {{ old('blood_group', $member?->blood_group) == 'AB+' ? 'selected' : '' }}>AB+</option>
                <option value="AB-" {{ old('blood_group', $member?->blood_group) == 'AB-' ? 'selected' : '' }}>AB-</option>
                <option value="O+" {{ old('blood_group', $member?->blood_group) == 'O+' ? 'selected' : '' }}>O+</option>
                <option value="O-" {{ old('blood_group', $member?->blood_group) == 'O-' ? 'selected' : '' }}>O-</option>
            </select>
        </div>
    </div>

    <div class="grid md:grid-cols-2 gap-6">
        <div class="mb-4">
            <label for="image" class="block text-sm font-medium text-gray-700 mb-2">ছবি</label>
            <input 
                type="file" 
                name="image" 
                id="image" 
                accept="image/*"
                onchange="previewFile(event, 'image_preview')"
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 transition duration-300"
                {{ $member ? 'disabled' : 'required' }}
            >
            <img 
                src="{{ $member && $member->image ? $member->image->src() : asset('images/default.png') }}" 
                id="image_preview" 
                class="mt-4 w-32 h-32 object-cover rounded-lg shadow-md"
                alt="Profile Preview"
            >
        </div>

        <div class="mb-4">
            <label for="signature" class="block text-sm font-medium text-gray-700 mb-2">স্বাক্ষর</label>
            <input 
                type="file" 
                name="signature" 
                id="signature" 
                accept="image/*"
                onchange="previewFile(event, 'signature_preview')"
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 transition duration-300"
                {{ $member ? 'disabled' : 'required' }}
            >
            <img 
                src="{{ $member && $member->signature ? $member->signature->src() : asset('images/default.png') }}" 
                id="signature_preview" 
                class="mt-4 w-32 h-16 object-cover rounded-lg shadow-md"
                alt="Signature Preview"
            >
        </div>
    </div>

    <div class="flex justify-end space-x-4 mt-6">
        <button 
            type="reset" 
            class="px-6 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition duration-300"
        >
            বাতিল
        </button>
        <button 
            type="submit" 
            class="px-6 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition duration-300"
        >
            সংরক্ষণ
        </button>
    </div>
</div>
