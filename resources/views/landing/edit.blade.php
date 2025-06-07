<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Landing Page UMKM
        </h2>
    </x-slot>
    <div class="py-8 px-2 min-h-screen bg-gray-50">
        <div class="max-w-5xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-8">
            <aside class="md:col-span-1">
                @include('partials.sidebar-umkm')
            </aside>
            <main class="md:col-span-3">
                <div class="bg-white rounded-xl shadow-md p-6 border border-yellow-100">
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Edit Landing Page</h3>
                    <form action="{{ route('landing.update', $page->id) }}" method="POST" enctype="multipart/form-data"
                        x-data="landingEditor()" x-init="init(@json(old('konten', $page->konten ?? [])), @json(old('bgColor', $page->bgColor ?? '#ffe082')), @json(old('textColor', $page->textColor ?? '#573500')))">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block font-semibold text-gray-700 mb-1">Slug</label>
                                <input type="text" name="slug" value="{{ old('slug', $page->slug ?? '') }}" required
                                    class="w-full px-4 py-2 border border-yellow-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400 transition shadow-sm">
                            </div>
                            <div>
                                <label class="block font-semibold text-gray-700 mb-1">Judul Landing Page</label>
                                <input type="text" name="judul" value="{{ old('judul', $page->judul ?? '') }}" required
                                    class="w-full px-4 py-2 border border-yellow-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400 transition shadow-sm">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            <div>
                                <label class="block font-semibold text-gray-700 mb-1">Warna Halaman</label>
                                <input type="color" x-model="bgColor" name="bgColor"
                                    class="w-14 h-10 p-0 border-2 border-yellow-200 rounded shadow">
                            </div>
                            <div>
                                <label class="block font-semibold text-gray-700 mb-1">Warna Teks Utama</label>
                                <input type="color" x-model="textColor" name="textColor"
                                    class="w-14 h-10 p-0 border-2 border-yellow-200 rounded shadow">
                            </div>
                        </div>

                        <div class="mb-4">
    <label class="block font-semibold text-gray-700 mb-1">Gambar Utama Landing Page</label>
    @if($page->gambar)
        <img src="{{ asset('storage/' . $page->gambar) }}" class="h-32 rounded mb-2">
    @endif
    <input type="file" name="gambar" class="block mt-1">
    <small class="text-gray-400">Upload gambar baru untuk mengganti gambar utama.</small>
</div>


                        {{-- DRAG & DROP KONTEN --}}
                        <div class="mb-6">
                            <label class="block font-bold mb-2">Susun Elemen Konten (Drag & Drop)</label>
                            <ul id="sortable-konten" class="space-y-3">
                                <template x-for="(item, idx) in kontens" :key="idx">
                                    <li :data-id="idx"
                                        class="bg-[#fffbe8] rounded shadow p-4 relative flex items-center group transition-all duration-200"
                                        :style="`color: ${textColor}`">
                                        <span class="cursor-move mr-3 text-gray-400 text-2xl select-none">&#x2630;</span>
                                        <!-- IMAGE -->
                                        <!-- IMAGE -->
<template x-if="item.type === 'image'">
    <div class="w-full">
        <input type="hidden" :name="'konten['+idx+'][type]'" value="image">
        <input type="hidden" :name="'konten['+idx+'][value]'" :value="item.value">
        <input type="hidden" :name="'konten['+idx+'][old_value]'" :value="item.value"> <!-- Tambahkan ini -->
        <template x-if="item.value">
            <img :src="previewImage(item.value)" class="h-24 rounded mb-2 shadow">
        </template>
        <input type="file" :name="'konten['+idx+'][file]'" @change="updateImage($event, idx)">
        <small class="text-gray-400">Upload gambar baru untuk mengganti.</small>
    </div>
</template>
                                        <!-- HEADING -->
                                        <template x-if="item.type === 'heading'">
                                            <div class="w-full">
                                                <input type="hidden" :name="'konten['+idx+'][type]'" value="heading">
                                                <div
                                                    contenteditable="true"
                                                    :ref="'editable'+idx"
                                                    @input="item.value = $refs['editable'+idx].innerText; $refs['hidden'+idx].value = item.value"
                                                    :style="styleString(item.style)"
                                                    class="border rounded py-2 px-2 bg-white mb-1 text-xl focus:outline-yellow-400"
                                                    x-text="item.value"
                                                    style="min-height:38px;"
                                                ></div>
                                                <input type="hidden" :name="'konten['+idx+'][value]'" :value="item.value" :ref="'hidden'+idx">
                                                <div class="flex flex-wrap gap-2 mt-2">
                                                    <button type="button" @click="toggleStyle(idx, 'bold')" :class="toolbarBtnClass(item, 'bold')"><b>B</b></button>
                                                    <button type="button" @click="toggleStyle(idx, 'italic')" :class="toolbarBtnClass(item, 'italic')"><i>I</i></button>
                                                    <button type="button" @click="changeFontSize(idx, 2)" class="toolbar-btn">A+</button>
                                                    <button type="button" @click="changeFontSize(idx, -2)" class="toolbar-btn">A-</button>
                                                    <button type="button" @click="setAlign(idx, 'left')" class="toolbar-btn">⯇</button>
                                                    <button type="button" @click="setAlign(idx, 'center')" class="toolbar-btn">≡</button>
                                                    <button type="button" @click="setAlign(idx, 'right')" class="toolbar-btn">⯈</button>
                                                    <button type="button" @click="toggleStyle(idx, 'uppercase')" :class="toolbarBtnClass(item, 'uppercase')">↑A</button>
                                                    <button type="button" @click="toggleStyle(idx, 'lowercase')" :class="toolbarBtnClass(item, 'lowercase')">↓a</button>
                                                    <input type="color" :value="item.style?.color || textColor" @input="setColor(idx, $event.target.value)" class="w-8 h-8 border ml-2" title="Warna Teks">
                                                </div>
                                            </div>
                                        </template>
                                        <!-- TEXT -->
                                        <template x-if="item.type === 'text'">
                                            <div class="w-full">
                                                <input type="hidden" :name="'konten['+idx+'][type]'" value="text">
                                                <div
                                                    contenteditable="true"
                                                    :ref="'editable'+idx"
                                                    @input="item.value = $refs['editable'+idx].innerText; $refs['hidden'+idx].value = item.value"
                                                    :style="styleString(item.style)"
                                                    class="border rounded py-2 px-2 bg-white mb-1 focus:outline-yellow-400"
                                                    x-text="item.value"
                                                    style="min-height:38px;"
                                                ></div>
                                                <input type="hidden" :name="'konten['+idx+'][value]'" :value="item.value" :ref="'hidden'+idx">
                                                <div class="flex flex-wrap gap-2 mt-2">
                                                    <button type="button" @click="toggleStyle(idx, 'bold')" :class="toolbarBtnClass(item, 'bold')"><b>B</b></button>
                                                    <button type="button" @click="toggleStyle(idx, 'italic')" :class="toolbarBtnClass(item, 'italic')"><i>I</i></button>
                                                    <button type="button" @click="changeFontSize(idx, 2)" class="toolbar-btn">A+</button>
                                                    <button type="button" @click="changeFontSize(idx, -2)" class="toolbar-btn">A-</button>
                                                    <button type="button" @click="setAlign(idx, 'left')" class="toolbar-btn">⯇</button>
                                                    <button type="button" @click="setAlign(idx, 'center')" class="toolbar-btn">≡</button>
                                                    <button type="button" @click="setAlign(idx, 'right')" class="toolbar-btn">⯈</button>
                                                    <button type="button" @click="toggleStyle(idx, 'uppercase')" :class="toolbarBtnClass(item, 'uppercase')">↑A</button>
                                                    <button type="button" @click="toggleStyle(idx, 'lowercase')" :class="toolbarBtnClass(item, 'lowercase')">↓a</button>
                                                    <input type="color" :value="item.style?.color || textColor" @input="setColor(idx, $event.target.value)" class="w-8 h-8 border ml-2" title="Warna Teks">
                                                </div>
                                            </div>
                                        </template>
                                        <!-- LIST -->
                                        <template x-if="item.type === 'list'">
                                            <div class="w-full">
                                                <input type="hidden" :name="'konten['+idx+'][type]'" value="list">
                                                <template x-for="(val, lid) in item.value" :key="lid">
                                                    <div class="flex items-center gap-2 mb-1">
                                                        <span class="text-yellow-600 text-lg">&#x2022;</span>
                                                        <input type="text"
                                                            x-model="item.value[lid]"
                                                            :name="'konten['+idx+'][value]['+lid+']'"
                                                            class="w-full px-2 py-1 border border-yellow-200 rounded">
                                                        <button type="button" @click="removeListItem(idx, lid)" class="text-red-400">x</button>
                                                    </div>
                                                </template>
                                                <button type="button" @click="addListItem(idx)" class="text-xs px-2 py-1 bg-yellow-200 rounded">+ Item List</button>
                                            </div>
                                        </template>
                                        <button type="button"
                                            @click="removeKonten(idx)"
                                            class="absolute top-2 right-2 text-red-400 font-bold opacity-60 hover:opacity-100 transition">×</button>
                                    </li>
                                </template>
                            </ul>
                            <div class="flex flex-wrap gap-2 mt-3">
                                <button type="button" @click="addKonten('heading')" class="px-3 py-1 bg-yellow-300 rounded">+ Judul</button>
                                <button type="button" @click="addKonten('text')" class="px-3 py-1 bg-yellow-300 rounded">+ Teks</button>
                                <button type="button" @click="addKonten('image')" class="px-3 py-1 bg-yellow-300 rounded">+ Gambar</button>
                                <button type="button" @click="addKonten('list')" class="px-3 py-1 bg-yellow-300 rounded">+ List</button>
                            </div>
                        </div>

                        {{-- Form Dinamis --}}
                        <div class="mb-6">
                            <label class="block font-semibold text-gray-700 mb-1">Form Custom (Field bisa diatur sendiri)</label>
                            <template x-for="(field, idx) in formFields" :key="idx">
                                <div class="bg-yellow-50 rounded-md p-3 mb-3 relative group flex gap-2 items-center">
                                    <input type="text" :name="'form_fields['+idx+'][label]'" x-model="formFields[idx].label"
                                        class="w-1/3 px-2 py-1 border border-yellow-300 rounded" placeholder="Label (misal: Nama)">
                                    <select :name="'form_fields['+idx+'][type]'" x-model="formFields[idx].type"
                                        class="w-1/4 px-2 py-1 border border-yellow-300 rounded">
                                        <option value="text">Teks</option>
                                        <option value="number">Nomor</option>
                                        <option value="date">Tanggal</option>
                                    </select>
                                    <input type="text" :name="'form_fields['+idx+'][placeholder]'" x-model="formFields[idx].placeholder"
                                        class="w-1/3 px-2 py-1 border border-yellow-300 rounded" placeholder="Placeholder (opsional)">
                                    <button type="button" @click="removeFormField(idx)"
                                        class="text-red-500 font-bold opacity-0 group-hover:opacity-100 transition text-lg">×</button>
                                </div>
                            </template>
                            <button type="button" @click="addFormField" class="bg-yellow-400 hover:bg-yellow-500 text-white px-4 py-1 rounded shadow transition">+ Tambah Field Form</button>
                            <div class="text-xs text-gray-500 mt-2">
                                Anda bisa menambah sebanyak apapun field sesuai kebutuhan (misal Nama, No WA, Tanggal Lahir, dst).
                            </div>
                        </div>

                        <div class="flex gap-2">
                            <button type="submit" class="bg-yellow-400 hover:bg-yellow-500 text-white font-semibold px-8 py-2 rounded-lg shadow transition">Simpan Perubahan</button>
                            <a href="{{ route('landing.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-2 rounded-lg shadow transition">Batal</a>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </div>
    <!-- Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <!-- SortableJS -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script>
        function landingEditor() {
            return {
                kontens: [],
                formFields: @json(old('form_fields', $page->form_fields ?? [])),
                bgColor: '#ffe082',
                textColor: '#573500',
                init(initData, bg, text) {
                    // Deep copy so Alpine doesn't reference old object
                    this.kontens = Array.isArray(initData) && initData.length ? JSON.parse(JSON.stringify(initData)) : [
                        {type:'heading', value:'Judul Landing', style:{bold:true, align:'center', fontSize:26}}
                    ];
                    this.bgColor = bg || '#ffe082';
                    this.textColor = text || '#573500';
                    document.body.style.background = this.bgColor;
                    this.$watch('bgColor', val => { document.body.style.background = val; });
                    this.$nextTick(() => {
                        if(window.Sortable && document.getElementById('sortable-konten')) {
                            Sortable.create(document.getElementById('sortable-konten'), {
                                animation: 180,
                                handle: '.cursor-move',
                                ghostClass: 'bg-yellow-200',
                                onEnd: evt => {
                                    if (evt.oldIndex !== evt.newIndex) {
                                        const moved = this.kontens.splice(evt.oldIndex, 1)[0];
                                        this.kontens.splice(evt.newIndex, 0, moved);
                                    }
                                }
                            });
                        }
                    });
                },
                addKonten(type) {
                    let val = '';
                    let style = {};
                    if(type==='image') val = '';
                    if(type==='heading') { val = 'Judul Baru'; style = {bold:true, align:'center', fontSize:26, color: this.textColor}; }
                    if(type==='text') { val = ''; style = {color: this.textColor}; }
                    if(type==='list') val = [''];
                    this.kontens.push({type:type, value:val, style: style});
                },
                removeKonten(idx) {
                    if(this.kontens.length>1) this.kontens.splice(idx,1);
                },
                addListItem(idx) {
                    this.kontens[idx].value.push('');
                },
                removeListItem(idx, lid) {
                    this.kontens[idx].value.splice(lid,1);
                },
                updateImage(event, idx) {
                    const file = event.target.files[0];
                    if(file) {
                        const reader = new FileReader();
                        reader.onload = e => {
                            this.kontens[idx].value = e.target.result;
                        };
                        reader.readAsDataURL(file);
                        // TODO: Upload file ke server on submit
                    }
                },
                previewImage(val) {
                    if (!val) return '';
                    return val.startsWith('data:') ? val : '/storage/'+val;
                },
                toggleStyle(idx, prop) {
                    this.kontens[idx].style = this.kontens[idx].style || {};
                    if(prop==='uppercase' || prop==='lowercase') {
                        this.kontens[idx].style.uppercase = (prop==='uppercase') ? !(this.kontens[idx].style.uppercase) : false;
                        this.kontens[idx].style.lowercase = (prop==='lowercase') ? !(this.kontens[idx].style.lowercase) : false;
                    } else {
                        this.kontens[idx].style[prop] = !this.kontens[idx].style[prop];
                    }
                },
                changeFontSize(idx, delta) {
                    this.kontens[idx].style.fontSize = (this.kontens[idx].style.fontSize||16) + delta;
                },
                setAlign(idx, align) {
                    this.kontens[idx].style.align = align;
                },
                setColor(idx, color) {
                    this.kontens[idx].style.color = color;
                },
                toolbarBtnClass(item, styleProp) {
                    return {
                        'toolbar-btn': true,
                        'bg-yellow-400 text-white': item.style?.[styleProp],
                        'border border-yellow-300': !item.style?.[styleProp]
                    };
                },
                styleString(style) {
                    let s = '';
                    if(style?.bold) s += 'font-weight:bold;';
                    if(style?.italic) s += 'font-style:italic;';
                    if(style?.fontSize) s += `font-size:${style.fontSize}px;`;
                    if(style?.align) s += `text-align:${style.align};`;
                    if(style?.uppercase) s += 'text-transform:uppercase;';
                    if(style?.lowercase) s += 'text-transform:lowercase;';
                    if(style?.color) s += `color:${style.color};`;
                    return s;
                },
                addFormField() {
                    this.formFields.push({label: '', type: 'text', placeholder: ''});
                },
                removeFormField(idx) {
                    this.formFields.splice(idx, 1);
                }
            }
        }
    </script>
    <style>
        .cursor-move { cursor: grab; }
        .toolbar-btn {
            font-size: 1.6em;
            padding: 0.1em 0.35em;
            border-radius: 0.35em;
            border: 1px solid #ffe082;
            background: #fffbe8;
            color: #4b3d01;
            transition: all 0.12s;
            box-shadow: 0 1px 2px #f5d06a44;
        }
        .toolbar-btn:hover, .toolbar-btn.bg-yellow-400 {
            background: #ffc107;
            color: #fff;
            border-color: #ffc107;
        }
        .toolbar-btn:focus { outline: 2px solid #ffc107; }
    </style>
</x-app-layout>