<div class="page" id="page-members">
      <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:.9rem">
        <div class="tab-row" style="margin-bottom:0">
          <button class="tab act" onclick="SalonApp.filterMember('all',this)">Semua</button>
          <button class="tab" onclick="SalonApp.filterMember('Gold',this)">Gold</button>
          <button class="tab" onclick="SalonApp.filterMember('Silver',this)">Silver</button>
          <button class="tab" onclick="SalonApp.filterMember('Bronze',this)">Bronze</button>
        </div>
        <button class="btn-pri" onclick="SalonApp.openMemberModal()">+ Tambah Member</button>
      </div>
      <div id="member-list"></div>
    </div>
