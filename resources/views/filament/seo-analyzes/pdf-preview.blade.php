<div class="space-y-4">
    @if ($pdfPreviewUrl)
        <div style="width: 100%; display: flex; justify-content: center;">
            <div style="width: 100%; max-width: 1200px; height: 700px;">
                <iframe src="{{ $pdfPreviewUrl }}"
                    style="width: 1200px; height: 700px; border-radius: 18px; border: 1px solid #e5e7eb; box-shadow: 0 10px 30px rgba(15, 23, 42, 0.1);"
                    allow="autoplay" allowfullscreen loading="lazy"></iframe>
            </div>
        </div>
    @else
        <div class="rounded-lg border border-yellow-300 bg-yellow-50 px-4 py-3 text-sm text-yellow-800">
            URL analisa belum tersedia atau bukan tautan PDF yang valid.
        </div>
    @endif
</div>
