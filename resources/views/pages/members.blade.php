<div class="page" id="page-members">
  <!-- Header -->
  <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
    <div class="flex flex-wrap gap-2">
      <button class="tab-btn active px-4 py-2 text-xs font-bold rounded-full border transition-all cursor-pointer" onclick="SalonApp.filterMember('all',this)">Semua</button>
      <button class="tab-btn px-4 py-2 text-xs font-bold rounded-full border border-gray-200 bg-white text-gray-600 hover:bg-gray-50 transition-all cursor-pointer" onclick="SalonApp.filterMember('Gold',this)">
        <span class="inline-block w-2 h-2 rounded-full bg-yellow-400 mr-1.5"></span>Gold
      </button>
      <button class="tab-btn px-4 py-2 text-xs font-bold rounded-full border border-gray-200 bg-white text-gray-600 hover:bg-gray-50 transition-all cursor-pointer" onclick="SalonApp.filterMember('Silver',this)">
        <span class="inline-block w-2 h-2 rounded-full bg-gray-400 mr-1.5"></span>Silver
      </button>
      <button class="tab-btn px-4 py-2 text-xs font-bold rounded-full border border-gray-200 bg-white text-gray-600 hover:bg-gray-50 transition-all cursor-pointer" onclick="SalonApp.filterMember('Bronze',this)">
        <span class="inline-block w-2 h-2 rounded-full bg-orange-400 mr-1.5"></span>Bronze
      </button>
    </div>
    <button class="bg-gradient-to-r from-brand-purple to-brand-purple-dark text-white font-bold py-2.5 px-5 rounded-xl shadow-md shadow-brand-purple/20 hover:shadow-lg hover:shadow-brand-purple/30 transform hover:-translate-y-0.5 transition-all text-sm flex items-center gap-2" onclick="SalonApp.openMemberModal()">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
      Tambah Member
    </button>
  </div>

  <!-- Member List -->
  <div class="space-y-3" id="member-list">
    <div class="text-center py-12 text-gray-400">
      <p class="text-sm font-medium">Memuat data member...</p>
    </div>
  </div>
</div>
