(() => {
  const nav = document.getElementById('sbv-nav');
  if (!nav) return;

  const links = nav.querySelectorAll('.sbv-link[data-spa="true"]');
  const indicator = document.getElementById('sbv-indicator');
  const content = document.getElementById('content-area');

  function moveIndicatorTo(el) {
    indicator.style.top = el.offsetTop + 'px';
  }

  function setActive(el) {
    links.forEach(a => a.classList.remove('active'));
    el.classList.add('active');
    moveIndicatorTo(el);
  }

  function ajaxLoad(url, pushState = true) {
    if (!content) return;
    content.innerHTML = '<div class="text-secondary">Loading...</div>';

    fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
      .then(res => {
        if (!res.ok) throw new Error('HTTP ' + res.status);
        return res.text();
      })
      .then(html => {
        content.innerHTML = html;
        if (pushState) history.pushState({ url }, '', url);
        window.scrollTo({ top: 0, behavior: 'smooth' });
      })
      .catch(err => {
        content.innerHTML = '<div class="text-danger">Load failed: ' + err.message + '</div>';
      });
  }

  // init indicator ที่ active ปัจจุบัน
  const current = nav.querySelector('.sbv-link.active') || links[0];
  if (current) moveIndicatorTo(current);

  // intercept click
  links.forEach(link => {
    link.addEventListener('click', e => {
      e.preventDefault();
      const url = link.getAttribute('href');
      setActive(link);
      ajaxLoad(url, true);
    });
  });

  // รองรับ back/forward
  window.addEventListener('popstate', e => {
    const url = (e.state && e.state.url) ? e.state.url : window.location.pathname;
    let match = Array.from(links).find(a => a.getAttribute('href') === url);
    if (!match) match = Array.from(links).find(a => url.startsWith(a.getAttribute('href')));
    if (match) setActive(match);
    ajaxLoad(url, false);
  });
})();
