{{-- resources/views/components/form/input-signature.blade.php --}}
@props([
    'name',
    'label' => null,
    'hint' => null,
    'value' => null,
    'variant' => 'primary',
    'size' => 'md',
    'errorKey' => null,
    'required' => false,
    'width' => 400,
    'height' => 200,
    'lineWidth' => 2,
    'lineColor' => '#000000',
    'clearLabel' => 'Löschen',
])

@php
    $errorKey = $errorKey ?: $name;
    $uniqueId = 'signature_' . uniqid();
@endphp

<div>
    @if($label)
        <div class="flex items-center justify-between">
            <x-ui-label :for="$name" :text="$label" :variant="$variant" :required="$required" :size="$size" class="mb-1"/>
            @if($hint)
                <span id="{{ $name }}-hint" class="text-sm/6 text-[color:var(--ui-muted)]">{{ $hint }}</span>
            @endif
        </div>
    @endif

    <div
        x-data="{
            canvas: null,
            ctx: null,
            isDrawing: false,
            lastX: 0,
            lastY: 0,
            signatureData: @entangle($attributes->wire('model')),

            init() {
                this.canvas = this.$refs.canvas;
                this.ctx = this.canvas.getContext('2d');

                // Canvas-Auflösung an tatsächliche Anzeigegröße anpassen
                this.$nextTick(() => { this.resizeCanvas(); });

                // Load existing signature if present
                if (this.signatureData) {
                    this.$nextTick(() => { this.loadSignature(); });
                }
            },

            resizeCanvas() {
                const rect = this.canvas.getBoundingClientRect();
                const dpr = window.devicePixelRatio || 1;
                this.canvas.width = rect.width * dpr;
                this.canvas.height = rect.height * dpr;
                this.ctx.scale(dpr, dpr);
                this.ctx.strokeStyle = '{{ $lineColor }}';
                this.ctx.lineWidth = {{ $lineWidth }};
                this.ctx.lineCap = 'round';
                this.ctx.lineJoin = 'round';
            },

            loadSignature() {
                if (!this.signatureData) return;
                const img = new Image();
                img.onload = () => {
                    this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);
                    this.ctx.drawImage(img, 0, 0);
                };
                img.src = this.signatureData;
            },

            getCoordinates(e) {
                const rect = this.canvas.getBoundingClientRect();

                if (e.touches && e.touches.length > 0) {
                    return {
                        x: e.touches[0].clientX - rect.left,
                        y: e.touches[0].clientY - rect.top
                    };
                }
                return {
                    x: e.clientX - rect.left,
                    y: e.clientY - rect.top
                };
            },

            startDrawing(e) {
                e.preventDefault();
                this.isDrawing = true;
                const coords = this.getCoordinates(e);
                this.lastX = coords.x;
                this.lastY = coords.y;
            },

            draw(e) {
                if (!this.isDrawing) return;
                e.preventDefault();

                const coords = this.getCoordinates(e);

                this.ctx.beginPath();
                this.ctx.moveTo(this.lastX, this.lastY);
                this.ctx.lineTo(coords.x, coords.y);
                this.ctx.stroke();

                this.lastX = coords.x;
                this.lastY = coords.y;
            },

            stopDrawing(e) {
                if (!this.isDrawing) return;
                e.preventDefault();
                this.isDrawing = false;
                this.saveSignature();
            },

            saveSignature() {
                this.signatureData = this.canvas.toDataURL('image/png');
            },

            clear() {
                this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);
                this.signatureData = null;
            },

            isEmpty() {
                return !this.signatureData;
            }
        }"
        class="space-y-2"
    >
        <div class="relative border border-[var(--ui-border)] rounded-lg bg-white overflow-hidden touch-none">
            <canvas
                x-ref="canvas"
                width="{{ $width }}"
                height="{{ $height }}"
                class="w-full cursor-crosshair"
                style="height: {{ $height }}px;"
                @mousedown="startDrawing($event)"
                @mousemove="draw($event)"
                @mouseup="stopDrawing($event)"
                @mouseleave="stopDrawing($event)"
                @touchstart="startDrawing($event)"
                @touchmove="draw($event)"
                @touchend="stopDrawing($event)"
                @touchcancel="stopDrawing($event)"
            ></canvas>

            {{-- Placeholder text when empty --}}
            <div
                x-show="isEmpty()"
                class="absolute inset-0 flex items-center justify-center pointer-events-none"
            >
                <span class="text-[var(--ui-muted)] text-sm">Hier unterschreiben</span>
            </div>
        </div>

        <div class="flex justify-end">
            <button
                type="button"
                @click="clear()"
                class="inline-flex items-center gap-1.5 px-3 py-1.5 text-sm text-[var(--ui-danger)] hover:bg-red-50 rounded-md transition"
            >
                @svg('heroicon-o-trash', 'w-4 h-4')
                {{ $clearLabel }}
            </button>
        </div>

        {{-- Hidden input for form submission --}}
        <input type="hidden" name="{{ $name }}" :value="signatureData" {{ $attributes->except(['wire:model', 'wire:model.live', 'wire:model.defer']) }} />
    </div>

    @error($errorKey)
        <span class="mt-1 text-[color:var(--ui-danger)] text-sm">{{ $message }}</span>
    @enderror
</div>
