
(() => {
  const script = document.currentScript;
  const botKey = script?.dataset?.bot;
  if (!botKey) return;

  const visitorIdKey = 'cv_visitor_id';
  const convKey = 'cv_conversation_' + botKey;

  const getVisitorId = () => {
    let v = localStorage.getItem(visitorIdKey);
    if (!v) { v = crypto.randomUUID(); localStorage.setItem(visitorIdKey, v); }
    return v;
  };

  const apiBase = (new URL(script.src)).origin + '/api';

  const root = document.createElement('div');
  root.id = 'chatverse-root';
  const shadow = root.attachShadow({ mode: 'open' });

  const link = document.createElement('link');
  link.rel = 'stylesheet';
  link.href = (new URL('./chatverse-widget.css', script.src)).toString();
  shadow.appendChild(link);

  const btn = document.createElement('button');
  btn.className = 'cv-btn';
  btn.innerHTML = `<img alt="Buddy" src="${(new URL('../../assets/buddy-head-256.webp', script.src)).toString()}"/><span>Chat</span>`;
  shadow.appendChild(btn);

  const panel = document.createElement('div');
  panel.className = 'cv-panel';
  panel.style.display = 'none';
  panel.innerHTML = `
    <div class="cv-header">
      <div class="brand">Buddy by Chatverse</div>
      <div class="title">Loading...</div>
    </div>
    <div class="cv-messages"></div>
    <div class="cv-lead">
      <input type="text" name="name" placeholder="Your name (optional)"/>
      <input type="email" name="email" placeholder="Email (recommended)"/>
      <input type="text" name="phone" placeholder="Phone (optional)"/>
      <button type="button">Send</button>
    </div>
    <div class="cv-footer">
      <input class="cv-input" placeholder="Type a message..." />
      <button class="cv-send" type="button">Send</button>
    </div>
  `;
  shadow.appendChild(panel);
  document.body.appendChild(root);

  const titleEl = () => panel.querySelector('.title');
  const msgWrap = () => panel.querySelector('.cv-messages');
  const input = () => panel.querySelector('.cv-input');
  const leadBox = () => panel.querySelector('.cv-lead');

  let botConfig = null;

  const addBubble = (role, text) => {
    const div = document.createElement('div');
    div.className = 'cv-bubble ' + (role === 'user' ? 'cv-user' : 'cv-ai');
    div.textContent = text;
    msgWrap().appendChild(div);
    msgWrap().scrollTop = msgWrap().scrollHeight;
  };

  const showLead = () => {
    const lb = leadBox();
    lb.style.display = 'flex';
    msgWrap().scrollTop = msgWrap().scrollHeight;
  };

  const sendLead = async () => {
    const lb = leadBox();
    const name = lb.querySelector('input[name=name]').value;
    const email = lb.querySelector('input[name=email]').value;
    const phone = lb.querySelector('input[name=phone]').value;
    const conversation_id = localStorage.getItem(convKey) || null;

    await fetch(apiBase + '/widget/lead', {
      method:'POST',
      headers:{'Content-Type':'application/json'},
      body: JSON.stringify({ public_key: botKey, conversation_id, name, email, phone })
    });
    addBubble('assistant', 'Thanks! We will follow up soon.');
    lb.style.display = 'none';
  };

  const sendMessage = async () => {
    const text = input().value.trim();
    if (!text) return;
    input().value = '';
    addBubble('user', text);

    const origin = location.origin;
    const visitor_id = getVisitorId();
    const conversation_id = localStorage.getItem(convKey) || null;

    const res = await fetch(apiBase + '/widget/message', {
      method:'POST',
      headers:{'Content-Type':'application/json'},
      body: JSON.stringify({ public_key: botKey, text, visitor_id, conversation_id, origin })
    });

    if (!res.ok) {
      addBubble('assistant', 'Sorry — this chatbot is not available on this domain.');
      return;
    }
    const json = await res.json();
    if (json.conversation_id) localStorage.setItem(convKey, json.conversation_id);
    addBubble('assistant', json.reply || 'Sorry — no response.');
    if (json.ask_lead) showLead();
  };

  const loadConfig = async () => {
    const res = await fetch(apiBase + '/widget/config/' + botKey);
    const json = await res.json();
    botConfig = json.bot;
    titleEl().textContent = botConfig.bot_name || 'Chatverse Assistant';

    const theme = botConfig.theme || {};
    panel.style.setProperty('--cv-bg', theme.bg || '#0b1020');
    panel.style.setProperty('--cv-primary', theme.primary || '#22c1ee');
    panel.style.setProperty('--cv-accent', theme.accent || '#a855f7');

    // initial welcome
    const welcome = botConfig.welcome_message || 'Hi! How can I help?';
    addBubble('assistant', welcome);
  };

  btn.addEventListener('click', () => {
    const open = panel.style.display !== 'none';
    panel.style.display = open ? 'none' : 'flex';
    if (!botConfig) loadConfig();
  });

  panel.querySelector('.cv-send').addEventListener('click', sendMessage);
  panel.querySelector('.cv-input').addEventListener('keydown', (e) => {
    if (e.key === 'Enter') sendMessage();
  });
  panel.querySelector('.cv-lead button').addEventListener('click', sendLead);
})();
