<div id="footerArea" class="mt-24 bg-green-50 border-t border-green-100">
    <footer>
        <div class="container mx-auto px-4">
            <div class="flex flex-col items-center text-center py-12">
                <div class="flex justify-center space-x-6 mb-6">
                    <a href="{{ route('home') }}" class="text-green-800 hover:text-green-900 transition duration-300 ease-in-out">Home</a>
                    <a href="{{ route('about_us') }}" class="text-green-800 hover:text-green-900 transition duration-300 ease-in-out">About Us</a>
                    <a href="{{ route('news.index') }}" class="text-green-800 hover:text-green-900 transition duration-300 ease-in-out">News</a>
                    <a href="#" class="text-green-800 hover:text-green-900 transition duration-300 ease-in-out">Contact</a>
                </div>

                <div class="flex justify-center space-x-6 mb-6">
                    <a href="#" target="_blank" class="text-green-700 hover:text-green-900 text-2xl transition duration-300 ease-in-out">
                        <i class="fab fa-facebook"></i>
                    </a>
                    <a href="#" target="_blank" class="text-green-700 hover:text-green-900 text-2xl transition duration-300 ease-in-out">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" target="_blank" class="text-green-700 hover:text-green-900 text-2xl transition duration-300 ease-in-out">
                        <i class="fab fa-linkedin"></i>
                    </a>
                    <a href="#" target="_blank" class="text-green-700 hover:text-green-900 text-2xl transition duration-300 ease-in-out">
                        <i class="fab fa-instagram"></i>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="bg-white border-t border-green-100 py-6">
            <div class="container mx-auto px-4 text-center">
                <p class="text-green-900">
                    স্বত্ব {{ date('Y') }} <a href="{{ route('home') }}" class="text-green-800 hover:underline">
                        দৌলতপুর প্রবাসী সামাজিক সংগঠন
                    </a> - সর্ব স্বত্ব সংরক্ষিত
                </p>
            </div>
        </div>
    </footer>
</div>

{!! theme()->customFooterCode() !!}
