// ── helpers ──────────────────────────────────────────────────────────────────
function lerp(a,b,t){return a+(b-a)*t}
function ease(t){return t<.5?2*t*t:-1+(4-2*t)*t}
function glow(ctx,color,blur){ctx.shadowBlur=blur;ctx.shadowColor=color}

// ── intersection observer ────────────────────────────────────────────────────
new IntersectionObserver(entries=>{
  entries.forEach(e=>{ if(e.isIntersecting) e.target.classList.add('show') })
},{threshold:.12}).observe && document.querySelectorAll('.phase').forEach(el=>{
  new IntersectionObserver(entries=>{
    entries.forEach(e=>{ if(e.isIntersecting) e.target.classList.add('show') })
  },{threshold:.12}).observe(el)
});
// trigger immediately for elements already in view
document.querySelectorAll('.phase').forEach(el=>{
  const r=el.getBoundingClientRect();
  if(r.top<window.innerHeight) el.classList.add('show');
});

// ════════════════════════════════════════════════════════════════════════════
// PHASE 1 — GIS CITY PLANNING
// ════════════════════════════════════════════════════════════════════════════
;(function(){
  const cv=document.getElementById('c1'),ctx=cv.getContext('2d');
  const W=cv.width,H=cv.height;
  let t=0;

  // buildings grid
  const buildings=[];
  for(let r=0;r<5;r++) for(let c=0;c<7;c++){
    if(Math.random()>.25) buildings.push({
      x:50+c*78, y:50+r*60,
      w:48+Math.random()*24, h:36+Math.random()*16,
      bh:8+Math.random()*40,
      hue:200+Math.random()*30
    });
  }

  // route through city
  const route=[{x:55,y:360},{x:150,y:290},{x:260,y:210},{x:370,y:270},{x:480,y:160},{x:565,y:215}];

  // floating scan nodes
  const nodes=Array.from({length:12},()=>({
    x:Math.random()*W, y:Math.random()*H,
    vx:(Math.random()-.5)*.4, vy:(Math.random()-.5)*.4,
    r:2+Math.random()*2
  }));

  function draw(){
    t+=.007;
    ctx.clearRect(0,0,W,H);

    // bg gradient
    let bg=ctx.createRadialGradient(W/2,H/2,0,W/2,H/2,W*.7);
    bg.addColorStop(0,'#081525'); bg.addColorStop(1,'#030810');
    ctx.fillStyle=bg; ctx.fillRect(0,0,W,H);

    // grid
    ctx.strokeStyle='rgba(0,100,200,.13)'; ctx.lineWidth=.5;
    for(let x=0;x<W;x+=28){ctx.beginPath();ctx.moveTo(x,0);ctx.lineTo(x,H);ctx.stroke()}
    for(let y=0;y<H;y+=28){ctx.beginPath();ctx.moveTo(0,y);ctx.lineTo(W,y);ctx.stroke()}

    // buildings — isometric-style with top face
    buildings.forEach(b=>{
      const bh=b.bh;
      // side face (darker)
      ctx.fillStyle=`hsla(${b.hue},50%,8%,.95)`;
      ctx.fillRect(b.x, b.y-bh+b.h, b.w, bh*.25);
      // front face
      ctx.fillStyle=`hsla(${b.hue},55%,12%,.95)`;
      ctx.fillRect(b.x, b.y-bh, b.w, b.h);
      // top edge glow
      ctx.strokeStyle=`hsla(${b.hue},80%,60%,.35)`;
      ctx.lineWidth=1;
      ctx.beginPath(); ctx.moveTo(b.x,b.y-bh); ctx.lineTo(b.x+b.w,b.y-bh); ctx.stroke();
      // window lights
      if(bh>20){
        for(let wy=b.y-bh+6;wy<b.y-6;wy+=10){
          for(let wx=b.x+4;wx<b.x+b.w-6;wx+=9){
            const on=Math.sin(t*1.5+wx*b.hue)>.2;
            ctx.fillStyle=on?`hsla(${b.hue},100%,70%,.5)`:'rgba(0,0,0,.3)';
            ctx.fillRect(wx,wy,5,5);
          }
        }
      }
    });

    // animated scan line
    const sy=(t*55)%H;
    let sl=ctx.createLinearGradient(0,sy-25,0,sy+5);
    sl.addColorStop(0,'rgba(0,180,255,0)');
    sl.addColorStop(1,'rgba(0,180,255,.12)');
    ctx.fillStyle=sl; ctx.fillRect(0,sy-25,W,30);

    // route path (draws in loop)
    const prog=((Math.sin(t*.4)+1)/2);
    const total=route.length-1;
    const drawn=prog*total;

    ctx.save();
    ctx.shadowBlur=16; ctx.shadowColor='#00b4ff';
    ctx.strokeStyle='#00b4ff'; ctx.lineWidth=2.5;
    ctx.setLineDash([10,5]); ctx.lineDashOffset=-t*18;
    ctx.beginPath(); ctx.moveTo(route[0].x,route[0].y);
    for(let i=0;i<Math.floor(drawn);i++) ctx.lineTo(route[i+1].x,route[i+1].y);
    if(Math.floor(drawn)<total){
      const f=drawn-Math.floor(drawn),p1=route[Math.floor(drawn)],p2=route[Math.floor(drawn)+1];
      ctx.lineTo(lerp(p1.x,p2.x,f),lerp(p1.y,p2.y,f));
    }
    ctx.stroke(); ctx.restore();

    // waypoint nodes
    route.forEach((wp,i)=>{
      if(i/total>prog&&i>0) return;
      const p=Math.sin(t*3+i)*.5+.5;
      ctx.save(); ctx.shadowBlur=18; ctx.shadowColor='#00ffcc';
      ctx.beginPath(); ctx.arc(wp.x,wp.y,6+p*5,0,Math.PI*2);
      ctx.strokeStyle=`rgba(0,255,204,${p*.4})`; ctx.lineWidth=1.5; ctx.stroke();
      ctx.beginPath(); ctx.arc(wp.x,wp.y,4,0,Math.PI*2);
      ctx.fillStyle='#00ffcc'; ctx.fill(); ctx.restore();
    });

    // floating AI nodes
    nodes.forEach(n=>{
      n.x+=n.vx; n.y+=n.vy;
      if(n.x<0||n.x>W) n.vx*=-1;
      if(n.y<0||n.y>H) n.vy*=-1;
      ctx.beginPath(); ctx.arc(n.x,n.y,n.r,0,Math.PI*2);
      ctx.fillStyle='rgba(0,160,255,.25)'; ctx.fill();
    });

    // HUD
    ctx.fillStyle='rgba(0,180,255,.6)'; ctx.font='10px monospace';
    ctx.fillText(`GPS 48.1374°N 11.5754°E`,10,H-28);
    ctx.fillText(`KI-Optimierung: ${Math.round(prog*100)}%  |  Knoten: ${route.length}`,10,H-14);

    requestAnimationFrame(draw);
  }
  draw();
})();

// ════════════════════════════════════════════════════════════════════════════
// PHASE 2 — UNDERGROUND HDD BORING
// ════════════════════════════════════════════════════════════════════════════
;(function(){
  const cv=document.getElementById('c2'),ctx=cv.getContext('2d');
  const W=cv.width,H=cv.height;
  let t=0;
  const soil=[];

  function spawnSoil(x,y){
    soil.push({x,y,vx:(Math.random()-.5)*3.5,vy:-(Math.random()*3+.5),life:1,
      s:2+Math.random()*3, h:20+Math.random()*15});
  }

  function drawLayer(y0,y1,c0,c1){
    let g=ctx.createLinearGradient(0,y0,0,y1);
    g.addColorStop(0,c0); g.addColorStop(1,c1);
    ctx.fillStyle=g; ctx.fillRect(0,y0,W,y1-y0);
  }

  function draw(){
    t+=.01;
    ctx.clearRect(0,0,W,H);

    const gY=120; // ground surface y

    // sky / above ground
    drawLayer(0,gY,'#050d1a','#08152a');

    // road surface
    drawLayer(gY-18,gY,'#1a1e28','#22262f');
    ctx.strokeStyle='rgba(255,200,0,.35)'; ctx.lineWidth=3;
    ctx.setLineDash([28,18]); ctx.lineDashOffset=-t*45;
    ctx.beginPath(); ctx.moveTo(0,gY-9); ctx.lineTo(W,gY-9); ctx.stroke();
    ctx.setLineDash([]);

    // soil layers
    drawLayer(gY,    gY+45, '#261a0a','#1c1208');  // gravel
    drawLayer(gY+45, gY+110,'#1e1508','#160f06');  // topsoil
    drawLayer(gY+110,gY+170,'#181208','#100d06');  // clay
    drawLayer(gY+170,H,     '#0e0c0a','#080806');  // rock

    // gravel texture
    for(let i=0;i<55;i++){
      ctx.beginPath();
      ctx.ellipse((i*53)%W, gY+5+(i*17)%36, 3+(i%3), 2+(i%2), i*.4, 0, Math.PI*2);
      ctx.fillStyle=`rgba(${90+i%35},${70+i%25},${45+i%20},.45)`;
      ctx.fill();
    }

    // layer labels
    [['Schotter',gY+22,'rgba(180,150,100,.5)'],
     ['Erdreich',gY+78,'rgba(160,110,60,.5)'],
     ['Lehm',    gY+140,'rgba(140,90,50,.5)'],
     ['Fels',    gY+185,'rgba(110,110,110,.45)']
    ].forEach(([l,y,c])=>{
      ctx.fillStyle=c; ctx.font='11px monospace'; ctx.fillText(l,10,y);
    });

    // drill depth markers (dashed vertical line at machine)
    const mx=60+(t*22%(W-120));
    ctx.strokeStyle='rgba(255,140,0,.2)'; ctx.lineWidth=1;
    ctx.setLineDash([4,4]);
    ctx.beginPath(); ctx.moveTo(mx,gY); ctx.lineTo(mx,gY+100); ctx.stroke();
    ctx.setLineDash([]);

    // bored tunnel (dark void behind machine)
    let tg=ctx.createLinearGradient(0,gY+90,0,gY+110);
    tg.addColorStop(0,'rgba(0,0,0,.85)'); tg.addColorStop(.5,'rgba(8,5,3,1)'); tg.addColorStop(1,'rgba(0,0,0,.85)');
    ctx.fillStyle=tg; ctx.fillRect(0,gY+90,mx-15,22);

    // orange conduit pipe already laid
    let pg=ctx.createLinearGradient(0,gY+94,0,gY+108);
    pg.addColorStop(0,'#ff7010'); pg.addColorStop(.5,'#ff8c20'); pg.addColorStop(1,'#cc4a00');
    ctx.fillStyle=pg; ctx.fillRect(0,gY+95,mx-18,12);
    ctx.strokeStyle='rgba(255,160,60,.35)'; ctx.lineWidth=1;
    ctx.beginPath(); ctx.moveTo(0,gY+95); ctx.lineTo(mx-18,gY+95); ctx.stroke();

    // machine body
    ctx.save();
    ctx.shadowBlur=22; ctx.shadowColor='#ff8800';
    let mg=ctx.createLinearGradient(mx-38,gY+92,mx+12,gY+112);
    mg.addColorStop(0,'#222'); mg.addColorStop(.5,'#444'); mg.addColorStop(1,'#1a1a1a');
    ctx.fillStyle=mg;
    ctx.beginPath();
    if(ctx.roundRect) ctx.roundRect(mx-38,gY+91,50,24,5);
    else ctx.rect(mx-38,gY+91,50,24);
    ctx.fill();

    // drill head (rotating blades)
    ctx.translate(mx+13,gY+103);
    ctx.rotate(t*12);
    ctx.fillStyle='#ff8800';
    for(let i=0;i<4;i++){
      ctx.rotate(Math.PI/2);
      ctx.beginPath(); ctx.moveTo(0,0); ctx.lineTo(7,2.5); ctx.lineTo(14,0); ctx.lineTo(7,-2.5); ctx.closePath(); ctx.fill();
    }
    ctx.restore();

    // soil particles
    if(Math.random()>.55) spawnSoil(mx+14,gY+103);
    soil.forEach((p,i)=>{
      p.x+=p.vx; p.y+=p.vy; p.vy+=.2; p.life-=.025;
      if(p.life<=0){soil.splice(i,1);return}
      ctx.beginPath(); ctx.arc(p.x,p.y,p.s*p.life,0,Math.PI*2);
      ctx.fillStyle=`hsla(${25+p.h},55%,${25+p.h}%,${p.life*.8})`; ctx.fill();
    });

    // GPS readout
    const pct=Math.round(((mx-60)/(W-180))*100);
    ctx.fillStyle='rgba(255,140,0,.7)'; ctx.font='11px monospace';
    ctx.fillText(`HDD Tiefe: 1.2 m  |  Steigung: 0.3%  |  Fortschritt: ${pct}%`,10,H-15);

    requestAnimationFrame(draw);
  }
  draw();
})();

// ════════════════════════════════════════════════════════════════════════════
// PHASE 3 — FIBER CABLE BLOWING
// ════════════════════════════════════════════════════════════════════════════
;(function(){
  const cv=document.getElementById('c3'),ctx=cv.getContext('2d');
  const W=cv.width,H=cv.height;
  let t=0;

  function drawTube(cy,radius,topColor,midColor){
    let g=ctx.createLinearGradient(0,cy-radius,0,cy+radius);
    g.addColorStop(0,topColor); g.addColorStop(.35,midColor);
    g.addColorStop(.65,midColor); g.addColorStop(1,'rgba(0,0,0,.9)');
    ctx.fillStyle=g; ctx.fillRect(0,cy-radius,W,radius*2);
    ctx.fillStyle='rgba(255,255,255,.05)'; ctx.fillRect(0,cy-radius,W,radius*.3);
  }

  function draw(){
    t+=.012;
    ctx.clearRect(0,0,W,H);

    ctx.fillStyle='#050810'; ctx.fillRect(0,0,W,H);

    // soil above
    let sg=ctx.createLinearGradient(0,0,0,H*.38);
    sg.addColorStop(0,'#0a0e08'); sg.addColorStop(1,'#0e1008');
    ctx.fillStyle=sg; ctx.fillRect(0,0,W,H*.38);

    // ground texture dots
    for(let i=0;i<80;i++){
      ctx.fillStyle=`rgba(${60+i%30},${50+i%20},${30+i%15},.3)`;
      ctx.fillRect((i*71)%W,(i*19)%(H*.38),2,1);
    }

    // === main duct system ===
    const mainY=H*.62;

    // outer protection (PE orange)
    drawTube(mainY, 40, 'rgba(70,35,8,.95)', 'rgba(185,75,10,.75)');

    // sub-ducts
    const subs=[
      {dy:-14,r:10,c0:'rgba(8,70,200,.9)',c1:'rgba(8,45,130,.8)',label:'Blau'},
      {dy:0,  r:10,c0:'rgba(200,10,10,.9)',c1:'rgba(130,10,10,.8)',label:'Rot'},
      {dy:14, r:10,c0:'rgba(8,160,8,.9)',c1:'rgba(8,100,8,.8)',label:'Grün'},
    ];
    subs.forEach(s=>drawTube(mainY+s.dy,s.r,s.c0,s.c1));

    // fiber strands in blue sub-duct
    const fColors=['#00aaff','#0088ee','#88ccff','#44aaff','#00ddff','#5599ff'];
    fColors.forEach((c,i)=>{
      const fy=mainY-18+i*3.5+Math.sin(t*1.5+i)*.3;
      ctx.save(); ctx.shadowBlur=5; ctx.shadowColor=c;
      ctx.strokeStyle=c; ctx.lineWidth=1.2;
      ctx.beginPath(); ctx.moveTo(0,fy); ctx.lineTo(W,fy); ctx.stroke();
      ctx.restore();
    });

    // pneumatic light pulse traveling through fiber
    const px=((t*160)%(W+80))-40;
    ctx.save();
    let pg=ctx.createRadialGradient(px,mainY-14,0,px,mainY-14,35);
    pg.addColorStop(0,'rgba(0,220,255,.95)');
    pg.addColorStop(.25,'rgba(0,160,255,.5)');
    pg.addColorStop(1,'rgba(0,80,200,0)');
    ctx.fillStyle=pg; ctx.fillRect(px-35,mainY-26,70,24);
    ctx.restore();

    // pressure gradient (already-pressurized section)
    let prg=ctx.createLinearGradient(0,mainY-22,W,mainY-22);
    const frac=Math.min((px+40)/(W+80),1);
    prg.addColorStop(0,'rgba(0,200,255,.25)');
    prg.addColorStop(frac,'rgba(0,200,255,.25)');
    prg.addColorStop(Math.min(frac+.005,1),'rgba(0,200,255,0)');
    prg.addColorStop(1,'rgba(0,200,255,0)');
    ctx.fillStyle=prg; ctx.fillRect(0,mainY-24,W,6);

    // cross-section cut line
    const cx=W*.72;
    ctx.strokeStyle='rgba(0,255,200,.5)'; ctx.lineWidth=1.5;
    ctx.setLineDash([6,5]); ctx.beginPath(); ctx.moveTo(cx,20); ctx.lineTo(cx,H-20); ctx.stroke();
    ctx.setLineDash([]);
    ctx.fillStyle='rgba(0,255,200,.5)'; ctx.font='10px monospace';
    ctx.fillText('Querschnitt →',cx+5,30);

    // cross-section circles
    [{y:mainY,r:40,c:'rgba(185,75,10,.65)',t:'PE Ø50'},
     {y:mainY-14,r:10,c:'rgba(8,70,200,.7)',t:'Ø12'},
     {y:mainY,r:10,c:'rgba(200,10,10,.7)',t:'Ø12'},
     {y:mainY+14,r:10,c:'rgba(8,160,8,.7)',t:'Ø12'},
    ].forEach(o=>{
      ctx.beginPath(); ctx.arc(cx,o.y,o.r,0,Math.PI*2);
      ctx.strokeStyle=o.c; ctx.lineWidth=2; ctx.stroke();
      ctx.fillStyle=o.c.replace(/[\d.]+\)$/,'.12)'); ctx.fill();
    });

    const pct=Math.round(Math.abs(Math.sin(t*.3))*100);
    ctx.fillStyle='rgba(0,255,200,.65)'; ctx.font='11px monospace';
    ctx.fillText(`Druck: 8.2 bar  |  Geschw.: 45 m/min  |  Verlegt: ${pct}%`,10,H-14);

    requestAnimationFrame(draw);
  }
  draw();
})();

// ════════════════════════════════════════════════════════════════════════════
// PHASE 4 — FIBER SPLICING + OTDR
// ════════════════════════════════════════════════════════════════════════════
;(function(){
  const cv=document.getElementById('c4'),ctx=cv.getContext('2d');
  const W=cv.width,H=cv.height;
  let t=0;

  // pre-generate OTDR trace
  const otdr=Array.from({length:120},(_,i)=>{
    let v=1-.007*i+(Math.random()-.5)*.008;
    if(i===50) v-=.11;
    if(i===75) v-=.045;
    return Math.max(v,.08);
  });

  function draw(){
    t+=.009;
    ctx.clearRect(0,0,W,H);
    ctx.fillStyle='#020408'; ctx.fillRect(0,0,W,H);

    // subtle grid bg
    ctx.strokeStyle='rgba(100,0,200,.07)'; ctx.lineWidth=.5;
    for(let x=0;x<W;x+=40){ctx.beginPath();ctx.moveTo(x,0);ctx.lineTo(x,H*.58);ctx.stroke()}
    for(let y=0;y<H*.58;y+=30){ctx.beginPath();ctx.moveTo(0,y);ctx.lineTo(W,y);ctx.stroke()}

    // === fiber ends ===
    const cy=H*.3;
    const gap=28+Math.sin(t*.7)*16;
    const lx=W/2-gap/2, rx=W/2+gap/2;

    // fiber body gradient
    const fg=ctx.createLinearGradient(0,cy-5,0,cy+5);
    fg.addColorStop(0,'#8ab0ff'); fg.addColorStop(.5,'#bbddff'); fg.addColorStop(1,'#3355bb');

    ctx.fillStyle=fg;
    ctx.fillRect(0,cy-5,lx,10);
    ctx.fillRect(rx,cy-5,W-rx,10);

    // cladding halo left
    let hl=ctx.createLinearGradient(lx-90,cy,lx,cy);
    hl.addColorStop(0,'rgba(0,80,255,0)'); hl.addColorStop(1,'rgba(100,200,255,.25)');
    ctx.fillStyle=hl; ctx.fillRect(lx-90,cy-18,90,36);

    // cladding halo right
    let hr=ctx.createLinearGradient(rx,cy,rx+90,cy);
    hr.addColorStop(0,'rgba(100,200,255,.25)'); hr.addColorStop(1,'rgba(0,80,255,0)');
    ctx.fillStyle=hr; ctx.fillRect(rx,cy-18,90,36);

    // === fusion arc when gap is small ===
    const arcStr=Math.max(0,(34-gap)/14);
    if(arcStr>0){
      ctx.save();
      ctx.shadowBlur=35*arcStr; ctx.shadowColor='#ffffff';
      // sparks
      for(let i=0;i<10;i++){
        const a=(t*18+i*36)*Math.PI/180;
        const sr=4+Math.sin(t*22+i)*3;
        ctx.beginPath(); ctx.arc(W/2+Math.cos(a)*sr, cy+Math.sin(a)*sr*.5, 2, 0, Math.PI*2);
        ctx.fillStyle=`rgba(255,255,255,${arcStr*.85})`; ctx.fill();
      }
      let fug=ctx.createRadialGradient(W/2,cy,0,W/2,cy,22);
      fug.addColorStop(0,`rgba(255,255,255,${arcStr})`);
      fug.addColorStop(.3,`rgba(120,200,255,${arcStr*.6})`);
      fug.addColorStop(1,'rgba(0,80,255,0)');
      ctx.fillStyle=fug; ctx.beginPath(); ctx.ellipse(W/2,cy,22,14,0,0,Math.PI*2); ctx.fill();
      ctx.restore();
    }

    // light pulse traveling through full fiber
    const lp=((t*110)%W);
    ctx.save();
    let lpg=ctx.createRadialGradient(lp,cy,0,lp,cy,16);
    lpg.addColorStop(0,'rgba(0,220,255,.85)'); lpg.addColorStop(1,'rgba(0,100,200,0)');
    ctx.fillStyle=lpg; ctx.beginPath(); ctx.ellipse(lp,cy,16,10,0,0,Math.PI*2); ctx.fill();
    ctx.restore();

    // splice quality badge
    ctx.save();
    const sp=Math.sin(t*3)*.2+.8;
    ctx.shadowBlur=12*sp; ctx.shadowColor='#bf00ff';
    ctx.strokeStyle=`rgba(191,0,255,${sp})`; ctx.lineWidth=1.5;
    ctx.fillStyle='rgba(30,0,50,.8)';
    ctx.beginPath();
    if(ctx.roundRect) ctx.roundRect(W*.38,cy-38,W*.24,26,6);
    else ctx.rect(W*.38,cy-38,W*.24,26);
    ctx.fill(); ctx.stroke();
    ctx.fillStyle=`rgba(191,0,255,${sp})`;
    ctx.font='bold 11px monospace';
    ctx.fillText('Spleißverlust: 0.018 dB',W*.39,cy-21);
    ctx.restore();

    // === OTDR graph ===
    const gx=25,gy=H*.62,gw=W-50,gh=H*.27;
    ctx.fillStyle='rgba(5,8,25,.9)'; ctx.fillRect(gx,gy,gw,gh);
    ctx.strokeStyle='rgba(0,100,200,.2)'; ctx.lineWidth=.5;
    for(let i=1;i<5;i++){
      const yy=gy+(gh/5)*i;
      ctx.beginPath(); ctx.moveTo(gx,yy); ctx.lineTo(gx+gw,yy); ctx.stroke();
    }
    for(let i=1;i<6;i++){
      const xx=gx+(gw/6)*i;
      ctx.beginPath(); ctx.moveTo(xx,gy); ctx.lineTo(xx,gy+gh); ctx.stroke();
    }

    // OTDR trace
    ctx.save(); ctx.shadowBlur=8; ctx.shadowColor='#bf00ff';
    ctx.strokeStyle='#bf00ff'; ctx.lineWidth=1.8;
    ctx.beginPath();
    otdr.forEach((v,i)=>{
      const px=gx+(i/120)*gw, py=gy+gh-v*gh*.88;
      i===0?ctx.moveTo(px,py):ctx.lineTo(px,py);
    });
    ctx.stroke(); ctx.restore();

    // moving scan cursor
    const sc=gx+(((t*.6)%1))*gw;
    ctx.strokeStyle='rgba(255,220,0,.6)'; ctx.lineWidth=1;
    ctx.setLineDash([3,3]);
    ctx.beginPath(); ctx.moveTo(sc,gy); ctx.lineTo(sc,gy+gh); ctx.stroke();
    ctx.setLineDash([]);

    // splice marker on graph
    const spliceX=gx+(50/120)*gw;
    ctx.strokeStyle='rgba(255,50,50,.5)'; ctx.lineWidth=1;
    ctx.beginPath(); ctx.moveTo(spliceX,gy); ctx.lineTo(spliceX,gy+gh); ctx.stroke();
    ctx.fillStyle='rgba(255,80,80,.6)'; ctx.font='9px monospace';
    ctx.fillText('Spleißstelle',spliceX+2,gy+10);

    ctx.fillStyle='rgba(191,0,255,.65)'; ctx.font='10px monospace';
    ctx.fillText('OTDR — Reflexionsmessung (1310nm)',gx,gy-6);
    ctx.fillStyle='rgba(0,200,255,.55)'; ctx.font='10px monospace';
    ctx.fillText('End-zu-End: OK  |  Dämpfung gesamt: 3.2 dB  |  Länge: 1840 m',gx,gy+gh+15);

    requestAnimationFrame(draw);
  }
  draw();
})();

// ════════════════════════════════════════════════════════════════════════════
// PHASE 5 — FTTH HOUSE
// ════════════════════════════════════════════════════════════════════════════
;(function(){
  const cv=document.getElementById('c5'),ctx=cv.getContext('2d');
  const W=cv.width,H=cv.height;
  let t=0;
  const data=[];

  function spawn(){
    data.push({life:1,size:1.5+Math.random()*2,color:Math.random()>.5?'#00ff88':'#00ffcc'});
  }

  function drawHouse(cx,cy,sc){
    ctx.save(); ctx.translate(cx,cy); ctx.scale(sc,sc);
    const w=78,h=100,rh=60;

    // house body
    let bg=ctx.createLinearGradient(0,-h,0,0);
    bg.addColorStop(0,'rgba(18,38,78,.97)'); bg.addColorStop(1,'rgba(10,20,50,.97)');
    ctx.fillStyle=bg;
    ctx.strokeStyle='rgba(0,180,255,.35)'; ctx.lineWidth=1.5;
    ctx.beginPath(); ctx.rect(-w,-h,w*2,h+5); ctx.fill(); ctx.stroke();

    // roof
    let rf=ctx.createLinearGradient(-w,-h-rh,w,-h);
    rf.addColorStop(0,'rgba(12,28,65,.97)'); rf.addColorStop(1,'rgba(18,38,78,.97)');
    ctx.fillStyle=rf;
    ctx.beginPath(); ctx.moveTo(-w-6,-h); ctx.lineTo(0,-h-rh); ctx.lineTo(w+6,-h); ctx.closePath();
    ctx.fill(); ctx.stroke();

    // chimney
    ctx.fillStyle='rgba(14,25,55,.95)'; ctx.strokeStyle='rgba(0,180,255,.25)';
    ctx.beginPath(); ctx.rect(30,-h-rh+20,16,rh-10); ctx.fill(); ctx.stroke();

    // windows (4)
    [[-45,-70],[-45,-35],[15,-70],[15,-35]].forEach(([wx,wy])=>{
      const glow=Math.sin(t*2+wx*.05)*.35+.65;
      ctx.fillStyle=`rgba(0,${Math.round(130*glow)},${Math.round(240*glow)},.4)`;
      ctx.fillRect(wx,wy,24,20); ctx.strokeStyle=`rgba(0,200,255,${glow*.5})`; ctx.strokeRect(wx,wy,24,20);
      // cross divider
      ctx.strokeStyle=`rgba(0,180,255,${glow*.3})`;
      ctx.beginPath(); ctx.moveTo(wx+12,wy); ctx.lineTo(wx+12,wy+20); ctx.stroke();
      ctx.beginPath(); ctx.moveTo(wx,wy+10); ctx.lineTo(wx+24,wy+10); ctx.stroke();
    });

    // door
    ctx.fillStyle='rgba(5,15,40,.95)'; ctx.strokeStyle='rgba(0,180,255,.3)';
    ctx.fillRect(-12,0-h+h-25,24,30); ctx.strokeRect(-12,0-h+h-25,24,30);
    // door handle
    ctx.beginPath(); ctx.arc(6,-10,2,0,Math.PI*2); ctx.fillStyle='rgba(0,200,255,.5)'; ctx.fill();

    // ONT terminal box (right side of house)
    const op=Math.sin(t*4)*.5+.5;
    ctx.save(); ctx.shadowBlur=15*op; ctx.shadowColor='#00ff88';
    ctx.fillStyle='rgba(0,25,15,.95)'; ctx.strokeStyle='#00ff88'; ctx.lineWidth=1.5;
    ctx.fillRect(w-5,-45,28,38); ctx.strokeRect(w-5,-45,28,38);
    // LEDs
    ['#00ff88','#00ff88','#ffaa00'].forEach((c,i)=>{
      ctx.beginPath(); ctx.arc(w+2+i*9,-32,3,0,Math.PI*2);
      ctx.fillStyle=(i<2&&op>.5)||i===2?c:'rgba(0,80,30,.6)'; ctx.fill();
    });
    ctx.fillStyle='rgba(0,255,136,.5)'; ctx.font='7px monospace';
    ctx.fillText('ONT',w,−12); ctx.restore();

    ctx.restore();
  }

  function draw(){
    t+=.01;
    ctx.clearRect(0,0,W,H);

    // night sky
    let sky=ctx.createLinearGradient(0,0,0,H*.7);
    sky.addColorStop(0,'#020408'); sky.addColorStop(1,'#040912');
    ctx.fillStyle=sky; ctx.fillRect(0,0,W,H*.7);

    // stars
    for(let i=0;i<60;i++){
      const sx=(i*137.5)%W, sy=(i*91)%(H*.55);
      const sb=Math.sin(t*1.5+i)*.3+.7;
      ctx.beginPath(); ctx.arc(sx,sy,1,0,Math.PI*2);
      ctx.fillStyle=`rgba(200,220,255,${sb*.55})`; ctx.fill();
    }

    // ground
    let gnd=ctx.createLinearGradient(0,H*.7,0,H);
    gnd.addColorStop(0,'#09132a'); gnd.addColorStop(1,'#060a18');
    ctx.fillStyle=gnd; ctx.fillRect(0,H*.7,W,H*.3);

    // underground cable (orange PE duct)
    const cableY=H*.84;
    ctx.strokeStyle='rgba(255,130,0,.65)'; ctx.lineWidth=7;
    ctx.beginPath(); ctx.moveTo(0,cableY); ctx.lineTo(W*.43,cableY); ctx.stroke();

    // riser cable up to house wall
    ctx.strokeStyle='rgba(255,130,0,.55)'; ctx.lineWidth=5;
    ctx.beginPath();
    ctx.moveTo(W*.43,cableY);
    ctx.bezierCurveTo(W*.43,H*.73, W*.53,H*.73, W*.53,H*.55);
    ctx.stroke();

    // data particles along cable path
    if(Math.random()>.8) spawn();
    data.forEach((p,i)=>{
      const prog=1-p.life;
      let px,py;
      if(prog<.55){
        const s=prog/.55;
        px=lerp(0,W*.43,ease(s)); py=cableY;
      } else {
        const s=(prog-.55)/.45;
        const t0=s, cx1=W*.43,cy1=H*.73, cx2=W*.53,cy2=H*.73, ex=W*.53,ey=H*.55;
        const u=1-t0;
        px=u*u*u*cx1+3*u*u*t0*cx1+3*u*t0*t0*cx2+t0*t0*t0*ex;
        py=u*u*u*cableY+3*u*u*t0*cy1+3*u*t0*t0*cy2+t0*t0*t0*ey;
      }
      p.life-=.007;
      if(p.life<=0){data.splice(i,1);return}
      ctx.save(); ctx.shadowBlur=10; ctx.shadowColor=p.color;
      ctx.beginPath(); ctx.arc(px,py,p.size,0,Math.PI*2);
      ctx.fillStyle=p.color; ctx.fill(); ctx.restore();
    });

    // draw house
    drawHouse(W*.47, H*.58, 1.15);

    // 1 Gbit/s badge
    const bp=Math.sin(t*2)*.25+.75;
    ctx.save(); ctx.shadowBlur=18*bp; ctx.shadowColor='#00ff88';
    ctx.fillStyle='rgba(0,25,15,.85)'; ctx.strokeStyle=`rgba(0,255,136,${bp})`; ctx.lineWidth=1.5;
    ctx.beginPath();
    if(ctx.roundRect) ctx.roundRect(W-135,18,115,48,8);
    else ctx.rect(W-135,18,115,48);
    ctx.fill(); ctx.stroke();
    ctx.restore();
    ctx.fillStyle='#00ff88'; ctx.font='bold 15px monospace';
    ctx.fillText('1 Gbit/s',W-122,40);
    ctx.fillStyle='rgba(0,255,136,.6)'; ctx.font='10px monospace';
    ctx.fillText('AKTIV  ●  FTTH',W-122,57);

    ctx.fillStyle='rgba(0,255,136,.65)'; ctx.font='11px monospace';
    ctx.fillText('ONT: Online  |  Down: 1000 Mbit/s  |  Up: 1000 Mbit/s',10,H-14);

    requestAnimationFrame(draw);
  }
  draw();
})();
