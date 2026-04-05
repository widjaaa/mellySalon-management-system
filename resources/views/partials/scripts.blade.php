<script>
// ===== DATA =====
const pages=['dashboard','payment','members','services','report','history'];
const navEls=document.querySelectorAll('.ni');
const titles={dashboard:'Dashboard',payment:'Pembayaran',members:'Data Member',services:'Kelola Layanan',report:'Laporan',history:'Riwayat Transaksi'};

let dbServices = @json($services);
let services = dbServices.map(s => ({
  id: s.id,
  name: s.name,
  cat: s.category,
  price: s.price,
  dur: s.duration,
  desc: s.description
}));
// nextSvcId not needed anymore


let dbMembers = @json($members);
let members = dbMembers.map(m => ({
  id: m.id,
  name: m.name,
  initials: m.name ? m.name.split(' ').map(w=>w?w[0]:'').join('').toUpperCase().slice(0,2) : 'M',
  tier: m.tier || 'Bronze',
  poin: m.poin || 0,
  total: m.total_visits || 0,
  spent: m.total_spent || 0,
  bday: m.bday || '',
  phone: m.phone || ''
}));

let reportRows=[];

let orderItems=[];
let payMethod='Tunai';
let grandTotal=0;
let activeSvcCat='Semua';
let editSvcId=null;
let delSvcId=null;

// ===== DATE =====
const now=new Date();
const dayNames=['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
const monthNames=['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
document.getElementById('date-chip').textContent=`${dayNames[now.getDay()]}, ${now.getDate()} ${monthNames[now.getMonth()]} ${now.getFullYear()}`;

// ===== NAVIGATION =====
function goPage(id,el){
  pages.forEach(p=>document.getElementById('page-'+p).classList.toggle('active',p===id));
  document.getElementById('pg-title').textContent=titles[id];
  navEls.forEach(n=>n.classList.remove('active'));
  if(el)el.classList.add('active');
  if(id==='report')renderReport('harian');
  if(id==='members')renderMembers('all');
  if(id==='services'){activeSvcCat='Semua';renderSvcPage();}
  if(id==='payment')populateSvcSelect();
}

// ===== DASHBOARD CHART =====
(function(){
  const days=['Sen','Sel','Rab','Kam','Jum','Sab','Min'];
  const vals=[320,410,280,520,390,610,440];
  const mx=Math.max(...vals);
  const rc=document.getElementById('rev-chart');
  rc.innerHTML=days.map((d,i)=>`<div class="rc"><div class="rb-wrap"><div class="rb${i===5?' hi':''}" style="height:${Math.round(vals[i]/mx*72)}px"></div></div><div class="rl">${d}</div></div>`).join('');
})();

// ===== PAYMENT =====
const catColors={Rambut:{bg:'#FBEAF0',c:'#993556'},Wajah:{bg:'#E6F1FB',c:'#185FA5'},Kuku:{bg:'#EAF3DE',c:'#3B6D11'},Tubuh:{bg:'#FAEEDA',c:'#633806'},Paket:{bg:'#F1EFE8',c:'#444441'},Lainnya:{bg:'#FBEAF0',c:'#72243E'}};

function populateSvcSelect(){
  const sel=document.getElementById('svc-sel');
  sel.innerHTML='<option value="">-- Pilih Layanan --</option>'+services.map(s=>`<option value="${s.id}">${s.name} — Rp ${s.price.toLocaleString('id-ID')}</option>`).join('');
}

function searchMember(){
  const v=document.getElementById('cust-name').value.toLowerCase();
  const hint=document.getElementById('member-hint');
  if(v.length<2){hint.style.display='none';return;}
  const found=members.find(m=>m.name.toLowerCase().includes(v));
  if(found){
    hint.style.display='block';
    const disc=found.tier==='Gold'?'10%':found.tier==='Silver'?'5%':'0%';
    hint.textContent=`✓ Member: ${found.name} · ${found.tier} · ${found.poin.toLocaleString('id-ID')} poin · Diskon ${disc}`;
    updateTotals();
  } else {
    hint.style.display='none';
    updateTotals();
  }
}

function addSvc(){
  const sel=document.getElementById('svc-sel');
  if(!sel.value)return;
  const svc=services.find(s=>s.id==sel.value);
  if(!svc)return;
  orderItems.push({name:svc.name,price:svc.price});
  sel.value='';
  renderOrder();
}

function removeItem(i){orderItems.splice(i,1);renderOrder();}

function renderOrder(){
  const list=document.getElementById('order-list');
  list.innerHTML=orderItems.map((it,i)=>`<div class="order-row"><span>${it.name}</span><span style="display:flex;align-items:center;gap:7px">Rp ${it.price.toLocaleString('id-ID')}<span onclick="removeItem(${i})" style="cursor:pointer;color:var(--text3);font-size:14px;line-height:1">×</span></span></div>`).join('');
  updateTotals();
}

function updateTotals(){
  const sub=orderItems.reduce((s,i)=>s+i.price,0);
  const nameV=document.getElementById('cust-name').value.toLowerCase();
  const found=nameV.length>=2?members.find(m=>m.name.toLowerCase().includes(nameV)):null;
  let discPct=found?(found.tier==='Gold'?10:found.tier==='Silver'?5:0):0;
  const disc=Math.round(sub*discPct/100);
  grandTotal=sub-disc;

  document.getElementById('order-subtotal').classList.toggle('hidden',!orderItems.length);
  document.getElementById('sub-val').textContent='Rp '+sub.toLocaleString('id-ID');

  const discRow=document.getElementById('disc-row');
  const grandRow=document.getElementById('grand-row');
  if(disc>0&&orderItems.length){
    discRow.style.display='flex';
    document.getElementById('disc-val').textContent='-Rp '+disc.toLocaleString('id-ID');
    grandRow.style.display='flex';
    document.getElementById('grand-val').textContent='Rp '+grandTotal.toLocaleString('id-ID');
  } else {
    discRow.style.display='none';
    grandRow.style.display='none';
    grandTotal=sub;
  }

  const pp=document.getElementById('poin-preview');
  if(orderItems.length&&found){
    const pGet=Math.floor(grandTotal/1000);
    pp.style.display='block';
    pp.textContent=`Member akan mendapat +${pGet.toLocaleString('id-ID')} poin dari transaksi ini`;
  } else pp.style.display='none';
}

function selPay(el,m){
  document.querySelectorAll('.pm').forEach(p=>p.classList.remove('sel'));
  el.classList.add('sel');payMethod=m;
  
  document.getElementById('cash-section').style.display=m==='Tunai'?'block':'none';
  document.getElementById('qris-section').style.display=m==='QRIS'?'block':'none';
  document.getElementById('transfer-section').style.display=m==='Transfer'?'block':'none';
  
  if(m==='Tunai') calcChange();
}

function calcChange(){
  const recv=parseInt(document.getElementById('cash-in').value)||0;
  const cr=document.getElementById('change-row');
  if(recv>0&&grandTotal>0){cr.style.display='flex';document.getElementById('change-v').textContent='Rp '+Math.max(0,recv-grandTotal).toLocaleString('id-ID');}
  else{cr.style.display='none';}
}

function setCash(val){
  const inp=document.getElementById('cash-in');
  inp.value = val==='pas' ? grandTotal : val;
  calcChange();
}

function copyRek(rek){
  navigator.clipboard.writeText(rek);
  showToast('Nomor Rekening '+rek+' disalin!');
}

async function doPayment(){
  if(!orderItems.length){alert('Tambahkan layanan terlebih dahulu.');return;}
  const name=document.getElementById('cust-name').value.trim()||'Pelanggan';
  const t=new Date();
  const time=t.getHours().toString().padStart(2,'0')+':'+t.getMinutes().toString().padStart(2,'0');
  const svcs=orderItems.map(i=>i.name).join(' + ');
  const nameL=name.toLowerCase();
  const found=members.find(m=>m.name.toLowerCase().includes(nameL));
  const pGet=found?Math.floor(grandTotal/1000):0;

  const payload = {
    member_id: found ? found.id : null,
    customer_name: name,
    services_summary: svcs,
    total_amount: grandTotal,
    payment_method: payMethod,
    poin_awarded: pGet
  };

  const headers = {
    'Content-Type': 'application/json',
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    'Accept': 'application/json'
  };

  try {
    const res = await fetch('/transactions', { method: 'POST', headers, body: JSON.stringify(payload) });
    if(!res.ok) throw new Error('Gagal menyimpan transaksi ke database');
    
    // UI Updates
    const hl=document.getElementById('hist-list');
    const row=document.createElement('div');
    row.className='row-item';
    row.innerHTML=`<span style="font-size:10px;color:var(--text3);min-width:36px">${time}</span><span style="flex:1">${name}</span><span style="font-size:11px;color:var(--text2)">${svcs}</span><span style="font-size:11px;color:var(--text3);margin:0 7px">${payMethod}</span><span style="font-weight:500">Rp ${grandTotal.toLocaleString('id-ID')}</span>`;
    
    // Hapus teks 'Belum ada riwayat' jika ada
    if(hl.innerHTML.includes('Belum ada riwayat')) hl.innerHTML = '';
    hl.prepend(row);

    reportRows.unshift({time,name,svcs,method:payMethod,isMember:!!found,total:grandTotal});

    if(found){found.poin+=pGet;found.total+=1;found.spent+=grandTotal;}

    orderItems=[];grandTotal=0;
    document.getElementById('cust-name').value='';
    document.getElementById('cash-in').value='';
    document.getElementById('member-hint').style.display='none';
    document.getElementById('change-row').style.display='none';
    document.getElementById('poin-preview').style.display='none';
    renderOrder();
    
    showToast('Pembayaran berhasil & tersimpan!');
    goPage('history', document.querySelectorAll('.ni')[5]);
  } catch(e) {
    alert(e.message);
  }
}

// ===== MEMBERS =====
const tierColorMap={Gold:{av:'#FAEEDA',avC:'#633806',badge:'pill-gold'},Silver:{av:'#F1EFE8',avC:'#2C2C2A',badge:'pill-silver'},Bronze:{av:'#FAECE7',avC:'#4A1B0C',badge:'pill-bronze'}};
const tierMax={Gold:3000,Silver:1000,Bronze:500};

function renderMembers(filter){
  const list=document.getElementById('member-list');
  const filtered=filter==='all'?members:members.filter(m=>m.tier===filter);
  if(!filtered.length){list.innerHTML='<div style="text-align:center;padding:2rem;color:var(--text3);font-size:12.5px">Belum ada member di kategori ini.</div>';return;}
  list.innerHTML=filtered.map(m=>{
    const tc=tierColorMap[m.tier];
    const disc=m.tier==='Gold'?'10%':m.tier==='Silver'?'5%':'0%';
    return`<div class="member-card">
      <div style="display:flex;align-items:center;gap:10px;margin-bottom:10px">
        <div class="av av-lg" style="background:${tc.av};color:${tc.avC}">${m.initials}</div>
        <div style="flex:1">
          <div style="font-size:13px;font-weight:500">${m.name}</div>
          <span class="pill ${tc.badge}">${m.tier}</span>
        </div>
        <div style="text-align:right">
          <div style="font-size:17px;font-weight:500">${m.poin.toLocaleString('id-ID')}</div>
          <div style="font-size:10px;color:var(--text3)">poin</div>
        </div>
      </div>
      <div class="poin-bar"><div class="poin-fill" style="width:${Math.min(100,Math.round(m.poin/tierMax[m.tier]*100))}%"></div></div>
      <div style="display:flex;justify-content:space-between;font-size:10px;color:var(--text3);margin-bottom:9px">
        <span>${m.poin.toLocaleString('id-ID')} / ${tierMax[m.tier].toLocaleString('id-ID')} poin${m.tier!=='Gold'?' ke tier berikutnya':' (maks)'}</span>
        <span>Ultah: ${m.bday}</span>
      </div>
      <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:6px">
        <div class="ms"><div class="ms-val">${m.total}x</div><div class="ms-lbl">Kunjungan</div></div>
        <div class="ms"><div class="ms-val">Rp ${(m.spent/1000000).toFixed(1)}jt</div><div class="ms-lbl">Total Belanja</div></div>
        <div class="ms"><div class="ms-val">${disc}</div><div class="ms-lbl">Diskon</div></div>
      </div>
      ${m.phone?`<div style="font-size:11px;color:var(--text3);margin-top:8px">📞 ${m.phone}</div>`:''}
    </div>`;
  }).join('');
}

function renderMemberDatalist(){
  const dl = document.getElementById('members-list');
  if(dl) dl.innerHTML = members.map(m=>`<option value="${m.name}"></option>`).join('');
}

function filterMember(f,el){
  document.querySelectorAll('#page-members .tab').forEach(b=>b.classList.remove('act'));
  el.classList.add('act');
  renderMembers(f);
}

function openMemberModal(){document.getElementById('m-name').value='';document.getElementById('m-phone').value='';document.getElementById('m-tier').value='Bronze';document.getElementById('m-bday').value='';document.getElementById('mem-modal').classList.remove('hidden');}
function closeMemModal(){document.getElementById('mem-modal').classList.add('hidden');}
async function saveMember(){
  const name=document.getElementById('m-name').value.trim();
  if(!name){alert('Nama member wajib diisi.');return;}
  const phone = document.getElementById('m-phone').value.trim();
  const bday = document.getElementById('m-bday').value.trim();
  const tier = document.getElementById('m-tier').value;

  const payload = {name, phone, bday, tier};
  const headers = {
    'Content-Type': 'application/json',
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
  };

  const res = await fetch(`/members`, { method: 'POST', headers, body: JSON.stringify(payload) });
  const data = await res.json();

  const initials = data.name.split(' ').map(w=>w[0]).join('').toUpperCase().slice(0,2);
  members.push({
    id: data.id,
    name: data.name,
    initials: initials,
    tier: data.tier || 'Bronze',
    poin: data.poin || 0,
    total: data.total_visits || 0,
    spent: data.total_spent || 0,
    bday: data.bday || '',
    phone: data.phone || ''
  });
  
  closeMemModal();
  renderMembers('all');
  document.querySelectorAll('#page-members .tab').forEach((b,i)=>{b.classList.toggle('act',i===0)});
  showToast('Member baru berhasil disimpan ke database!');
}

// ===== SERVICES =====
function renderSvcPage(){
  const allCats=['Semua',...new Set(services.map(s=>s.cat))];
  document.getElementById('svc-tabs').innerHTML=allCats.map(c=>`<button class="tab${c===activeSvcCat?' act':''}" onclick="setSvcCat('${c}',this)">${c}${c==='Semua'?` (${services.length})`:` (${services.filter(s=>s.cat===c).length})`}</button>`).join('');
  const filtered=activeSvcCat==='Semua'?services:services.filter(s=>s.cat===activeSvcCat);
  document.getElementById('svc-sub').textContent=activeSvcCat==='Semua'?`${services.length} layanan dari ${new Set(services.map(s=>s.cat)).size} kategori`:`${filtered.length} layanan di kategori ${activeSvcCat}`;
  const prices=services.map(s=>s.price);
  document.getElementById('ss-total').textContent=services.length;
  document.getElementById('ss-cat').textContent=new Set(services.map(s=>s.cat)).size;
  document.getElementById('ss-low').textContent=prices.length?'Rp '+Math.min(...prices).toLocaleString('id-ID'):'—';
  document.getElementById('ss-high').textContent=prices.length?'Rp '+Math.max(...prices).toLocaleString('id-ID'):'—';
  const grid=document.getElementById('svc-grid');
  if(!filtered.length){grid.innerHTML=`<div style="text-align:center;padding:2rem;color:var(--text3);font-size:12.5px;grid-column:1/-1">Belum ada layanan. Klik "+ Tambah Layanan".</div>`;return;}
  grid.innerHTML=filtered.map(s=>{
    const c=catColors[s.cat]||catColors['Lainnya'];
    return`<div class="svc-card">
      <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:8px">
        <div style="font-size:13px;font-weight:500">${s.name}</div>
        <span class="svc-cat-pill" style="background:${c.bg};color:${c.c}">${s.cat}</span>
      </div>
      ${s.desc?`<div style="font-size:11px;color:var(--text2);line-height:1.5">${s.desc}</div>`:''}
      <div style="display:flex;align-items:center;justify-content:space-between;margin-top:2px">
        <div><div class="svc-price">Rp ${s.price.toLocaleString('id-ID')}</div>${s.dur?`<div class="svc-dur">${s.dur} menit</div>`:''}</div>
        <div style="display:flex;gap:5px">
          <button class="btn-edit-sm" onclick="openEditSvc(${s.id})">Edit</button>
          <button class="btn-del-sm" onclick="openDelSvc(${s.id})">Hapus</button>
        </div>
      </div>
    </div>`;
  }).join('');
}

function setSvcCat(c,el){
  activeSvcCat=c;
  document.querySelectorAll('#svc-tabs .tab').forEach(t=>t.classList.remove('act'));
  if(el)el.classList.add('act');
  renderSvcPage();
}

function openSvcModal(){
  editSvcId=null;
  document.getElementById('svc-modal-title').textContent='Tambah Layanan Baru';
  ['f-name','f-price','f-dur','f-desc'].forEach(id=>document.getElementById(id).value='');
  document.getElementById('f-cat').value='';
  document.getElementById('svc-modal').classList.remove('hidden');
  setTimeout(()=>document.getElementById('f-name').focus(),50);
}

function openEditSvc(id){
  const s=services.find(x=>x.id===id);if(!s)return;
  editSvcId=id;
  document.getElementById('svc-modal-title').textContent='Edit Layanan';
  document.getElementById('f-name').value=s.name;
  document.getElementById('f-cat').value=s.cat;
  document.getElementById('f-price').value=s.price;
  document.getElementById('f-dur').value=s.dur||'';
  document.getElementById('f-desc').value=s.desc||'';
  document.getElementById('svc-modal').classList.remove('hidden');
}

function closeSvcModal(){document.getElementById('svc-modal').classList.add('hidden');editSvcId=null;}

async function saveSvc(){
  const name=document.getElementById('f-name').value.trim();
  const cat=document.getElementById('f-cat').value;
  const price=parseInt(document.getElementById('f-price').value)||0;
  const dur=parseInt(document.getElementById('f-dur').value)||0;
  const desc=document.getElementById('f-desc').value.trim();
  if(!name){alert('Nama layanan wajib diisi.');return;}
  if(!cat){alert('Pilih kategori layanan.');return;}
  if(!price){alert('Harga wajib diisi.');return;}

  const payload = {name, category: cat, price, duration: dur, description: desc};
  const headers = {
    'Content-Type': 'application/json',
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    'Accept': 'application/json'
  };

  try {
    let url = editSvcId ? `/services/${editSvcId}` : `/services`;
    let method = editSvcId ? 'PUT' : 'POST';

    const res = await fetch(url, { method, headers, body: JSON.stringify(payload) });
    
    if(!res.ok){
        const err = await res.json();
        alert('Gagal menyimpan layar: ' + (err.message || 'Error server'));
        return;
    }

    const data = await res.json();

    if(editSvcId){
      const idx=services.findIndex(s=>s.id===editSvcId);
      if(idx>=0)services[idx]={...services[idx],name,cat,price,dur,desc};
      showToast('Layanan berhasil diperbarui');
    } else {
      services.push({id: data.id, name, cat, price, dur, desc});
      showToast('Layanan baru berhasil ditambahkan');
    }
    closeSvcModal();
    renderSvcPage();
    populateSvcSelect();
  } catch(e) {
    alert('Terjadi kesalahan jaringan: ' + e.message);
  }
}

function openDelSvc(id){
  delSvcId=id;
  const s=services.find(x=>x.id===id);
  document.getElementById('del-name').textContent=s?s.name:'layanan ini';
  document.getElementById('del-modal').classList.remove('hidden');
}
function closeDelModal(){document.getElementById('del-modal').classList.add('hidden');delSvcId=null;}
async function confirmDel(){
  if(delSvcId){
    const headers = {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    };
    await fetch(`/services/${delSvcId}`, { method: 'DELETE', headers });
    services=services.filter(s=>s.id!==delSvcId);
  }
  closeDelModal();
  if(activeSvcCat!=='Semua'&&!services.find(s=>s.cat===activeSvcCat))activeSvcCat='Semua';
  renderSvcPage();
  populateSvcSelect();
  showToast('Layanan berhasil dihapus');
}

// ===== REPORT =====
function renderReport(period){
  const sum=[
    {label:'Total Transaksi',val:reportRows.length+'x'},
    {label:'Total Pendapatan',val:'Rp '+reportRows.reduce((s,r)=>s+r.total,0).toLocaleString('id-ID')},
    {label:'Rata-rata Transaksi',val:'Rp '+(reportRows.length?Math.round(reportRows.reduce((s,r)=>s+r.total,0)/reportRows.length):0).toLocaleString('id-ID')},
  ];
  document.getElementById('rep-summary').innerHTML=sum.map(s=>`<div class="mc"><div class="mc-lbl">${s.label}</div><div class="mc-val" style="font-size:17px">${s.val}</div></div>`).join('');
  document.getElementById('rep-body').innerHTML=reportRows.map(r=>`<tr><td>${r.time}</td><td>${r.name}</td><td>${r.svcs}</td><td>${r.method}</td><td>${r.isMember?'<span class="pill pill-member">Member</span>':'—'}</td><td style="text-align:right;font-weight:500">Rp ${r.total.toLocaleString('id-ID')}</td></tr>`).join('');
}

function setReport(p,el){
  document.querySelectorAll('#page-report .tab').forEach(b=>b.classList.remove('act'));
  el.classList.add('act');
  renderReport(p);
}

function exportCSV(){
  const header='Waktu,Pelanggan,Layanan,Metode,Member,Total\n';
  const rows=reportRows.map(r=>`${r.time},"${r.name}","${r.svcs}",${r.method},${r.isMember?'Ya':'Tidak'},${r.total}`).join('\n');
  const blob=new Blob(['\uFEFF'+header+rows],{type:'text/csv;charset=utf-8'});
  const a=document.createElement('a');
  a.href=URL.createObjectURL(blob);
  a.download='laporan-salon-cantik.csv';
  a.click();
  showToast('File CSV berhasil diunduh');
}

function printReport(){window.print();}

// ===== TOAST =====
function showToast(msg){
  const t=document.getElementById('toast');
  t.textContent=msg;t.classList.add('show');
  setTimeout(()=>t.classList.remove('show'),2800);
}

// ===== CLOSE MODAL ON BG CLICK =====
document.getElementById('svc-modal').addEventListener('click',function(e){if(e.target===this)closeSvcModal();});
document.getElementById('del-modal').addEventListener('click',function(e){if(e.target===this)closeDelModal();});
document.getElementById('mem-modal').addEventListener('click',function(e){if(e.target===this)closeMemModal();});

renderReport('harian');
populateSvcSelect();
renderMemberDatalist();
</script>
