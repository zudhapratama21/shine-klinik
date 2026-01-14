 <div class="modal fade" id="treatment{{ $item->id }}" tabindex="-1" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered lg:min-w-[1140px]">
         <div class="modal-content">
             <div class="modal-body p-8">
                 <div class="absolute top-0 right-0 p-3">
                     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                         <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x text-gray-700"
                             width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                             fill="none" stroke-linecap="round" stroke-linejoin="round">
                             <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                             <path d="M18 6l-12 12" />
                             <path d="M6 6l12 12" />
                         </svg>
                     </button>
                 </div>
                 <div class="flex flex-wrap">
                     <div class="md:w-1/2">
                         <!-- img slide -->
                         <div class="product productModal" id="productModal">
                             <div class="zoom" onmousemove="zoom(event)"
                                 style="
                      background-image: url({{ asset('storage/' . $item->gambar) }});
                    ">
                                 <!-- img -->
                                 <!-- img -->
                                 <img src="{{ asset('storage/' . $item->gambar) }}" width="250px" height="250px" />
                             </div>
                         </div>
                     </div>
                     <div class="md:w-1/2 pr-4 pl-4">
                         <div class="lg:pl-10 mt-6 md:mt-0">
                             <div class="flex flex-col gap-4">
                                 <!-- content -->
                                 <a href="#!" class="block text-green-600">{{ $item->kategoritreatment->name }}</a>
                                 <!-- heading -->
                                 <h1>{{ Str::ucfirst($item->nama) }}</h1>
                                 <div class="flex flex-col gap-2">
                                     <div class="flex items-center">
                                     </div>
                                     <div class="text-md">
                                         <span class="text-gray-900 font-semibold">Rp
                                             {{ number_format($item->harga, 0, ',', '.') }}</span>
                                     </div>
                                 </div>
                                 <!-- hr -->
                                 <div class="flex flex-col gap-6">
                                     <hr />
                                     <div class="flex flex-wrap justify-start gap-2 items-center">
                                         <div class="lg:w-1/3 md:w-2/5 w-full grid">
                                             <!-- button -->
                                             <!-- btn -->
                                             <a href="https://wa.me/6282117516161?text=Halo%20Admin%2C%20saya%20ingin%20konsultasi%20treatment"
                                                 target="_blank"
                                                 class="btn bg-green-600 text-white border-green-600 disabled:opacity-50 disabled:pointer-events-none hover:text-white hover:bg-green-700 hover:border-green-700 active:bg-green-700 active:border-green-700 focus:outline-none focus:ring-4 focus:ring-green-300 justify-center">
                                                 Hubungi Kami
                                             </a>
                                         </div>
                                     </div>
                                     <!-- hr -->
                                     <hr />
                                 </div>
                                 <div>
                                     <!-- table -->
                                     <table class="text-left w-full">
                                         <tbody>
                                             <tr>
                                                 <td class="px-6 py-3">Deskripsi:</td>
                                             </tr>
                                             <tr>
                                                 <td class="px-6 py-3">{!! $item->deskripsi !!}</td>
                                             </tr>
                                         </tbody>
                                     </table>
                                 </div>
                                 <div>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div>
