<div xmlns:x-filament="http://www.w3.org/1999/html">

    <div class="grid gap-y-2">
        <!-- Label and Asterisk -->
        <div class="flex items-center gap-x-3 justify-between">
            <label for="{{ $getId() }}" class="fi-fo-field-wrp-label inline-flex items-center gap-x-3">
                <span class="text-sm font-medium leading-6 text-gray-950 dark:text-white">
                    {{ $getLabel() ?? 'Input Label' }}
                    @if($isRequired())
                        <sup class="text-danger-600 dark:text-danger-400 font-medium">*</sup>
                    @endif
                </span>
            </label>
        </div>

        <x-filament::input.wrapper class="relative">
            <x-filament::input
                    type="text"
                    name="{{ $getName() }}"
                    id="{{ $getId() }}"
                    value="{{ $getState() }}"
                    placeholder="{{ $getPlaceholder() }}"
                    class="w-full pr-10"
            />

            <button type="button" onclick="toggleScanner()" class="absolute inset-y-0 right-0 flex items-center pr-3 focus:outline-none" aria-label="Scan Barcode">
                <!-- Dynamic Icon -->
                @if($getExtraAttributes()['icon'] ?? null)
                    <span class="text-gray-400 dark:text-gray-200">
                        <x-dynamic-component :component="$getExtraAttributes()['icon']" class="w-5 h-5" />
                    </span>
                @else
                    <!-- Default Barcode Icon if no icon is specified -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400 dark:text-gray-200" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path d="M3 4h2v16H3V4zm4 0h2v16H7V4zm4 0h2v16h-2V4zm4 0h2v16h-2V4zm4 0h2v16h-2V4z"/>
                    </svg>
                @endif
            </button>
        </x-filament::input.wrapper>
    </div>

    <!-- Scanner Container -->
    <div id="scanner-container" class="mt-4 hidden">
        <video id="scanner" autoplay class="rounded-lg shadow"></video>
        <div class="overlay">
            <div class="scan-area"></div>
        </div>
    </div>

    <!-- ZXing Library -->
    <script src="https://unpkg.com/@zxing/library@latest"></script>
    <script>
      const codeReader = new ZXing.BrowserMultiFormatReader();
      let isScanning = false;

      function toggleScanner() {
        const scannerContainer = document.getElementById('scanner-container');
        if (scannerContainer.classList.contains('hidden')) {
          startCamera(); // Start the camera if scanner is hidden
          scannerContainer.classList.remove('hidden');
        } else {
          stopScanning(); // Stop scanning if scanner is visible
          scannerContainer.classList.add('hidden');
        }
      }

      function startScanner(selectedDeviceId) {
        codeReader.decodeFromVideoDevice(selectedDeviceId, 'scanner', (result, err) => {
          const scanArea = document.querySelector('.scan-area');
          if (result) {
            document.getElementById('{{ $getId() }}').value = result.text; // Set barcode value
            scanArea.style.borderColor = 'green';
            stopScanning(); // Optionally stop scanning after successful read
          } else if (err && !(err instanceof ZXing.NotFoundException)) {
            console.error(err);
          } else {
            scanArea.style.borderColor = 'red';
          }
        });
      }

      function stopScanning() {
        isScanning = false;
        const video = document.getElementById('scanner');
        if (video.srcObject) {
          video.srcObject.getTracks().forEach(track => track.stop());
        }
        video.style.display = 'none';
      }

      function startCamera() {
        codeReader.getVideoInputDevices().then((videoInputDevices) => {
          const rearCamera = videoInputDevices.find(device => device.label.toLowerCase().includes('back') || device.label.toLowerCase().includes('rear'));
          const selectedDeviceId = rearCamera ? rearCamera.deviceId : videoInputDevices[0].deviceId;

          navigator.mediaDevices.getUserMedia({ video: { deviceId: { exact: selectedDeviceId } } })
            .then(function (stream) {
              const video = document.getElementById('scanner');
              video.srcObject = stream;
              video.style.display = 'block';
              startScanner(selectedDeviceId);
            })
            .catch(function (err) {
              console.error("Error accessing the camera: ", err);
              alert("Camera access is required to scan barcodes.");
            });
        }).catch((err) => {
          console.error(err);
        });
      }
    </script>

</div>
