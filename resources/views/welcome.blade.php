<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Churras SOS — Seu mestre churrasqueiro com IA</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script src="https://cdn.tailwindcss.com"></script>
        <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
        <style>
            .md p { margin-bottom: .5rem; }
            .md ul { list-style: disc; padding-left: 1.25rem; margin-bottom: .5rem; }
            .md ol { list-style: decimal; padding-left: 1.25rem; margin-bottom: .5rem; }
            .md strong { font-weight: 700; }
            .md h1, .md h2, .md h3 { font-weight: bold; margin: .5rem 0 .25rem; }
            .md h1 { font-size: 1.25rem; }
            .md h2 { font-size: 1.125rem; }
            .md code { background: #1c1917; border-radius: .25rem; padding: 0 .25rem; font-size: .8em; }
            .md pre { background: #1c1917; border-radius: .5rem; padding: .5rem; overflow-x: auto; margin-bottom: .5rem; }
        </style>
    </head>
    <body class="min-h-screen bg-stone-950 text-stone-200 antialiased">
        {{-- fundo com textura de churrasco (brasa), bem transparente --}}
        <div class="pointer-events-none fixed inset-0 bg-cover bg-center opacity-15"
            style="background-image: url('https://images.pexels.com/photos/631520/pexels-photo-631520.jpeg?auto=compress&cs=tinysrgb&w=1600')"></div>

        <div class="relative mx-auto flex max-w-4xl flex-col gap-10 px-4 py-12">
            {{-- HERO: apresentação do tema --}}
            <header class="text-center">
                <p class="text-sm font-semibold uppercase tracking-[0.3em] text-orange-500">Tradição à brasa</p>
                <h1 class="mt-3 text-4xl font-black tracking-tight text-stone-100 sm:text-6xl">
                    Churras SOS <span class="text-orange-500">🔥</span>
                </h1>
                <p class="mx-auto mt-4 max-w-2xl text-stone-400">
                    O churrasco é uma das tradições mais amadas do Brasil: carne no ponto, fogo aceso e boa companhia.
                    Diga como será o seu evento — quantas pessoas, preferências, orçamento — e nossa IA monta o plano completo
                    com quantidades, receitas e boas práticas.
                </p>
            </header>

            {{-- CHAT no estilo ChatGPT/OpenCode --}}
            <section class="flex flex-col overflow-hidden rounded-3xl border border-stone-800 bg-stone-900/70 shadow-2xl backdrop-blur">
                <div class="border-b border-stone-800 px-6 py-4">
                    <h2 class="font-bold text-stone-100">Converse com o Churras SOS</h2>
                    <p class="text-xs text-stone-500">Ex.: "Somos 12 pessoas, metade prefere frango, com orçamento apertado"</p>
                </div>

                <div id="messages" class="flex max-h-[50vh] min-h-64 flex-col gap-4 overflow-y-auto px-6 py-6">
                    <div class="max-w-[85%] self-start rounded-2xl rounded-bl-md border border-stone-800 bg-stone-950 px-4 py-3 text-sm text-stone-300">
                        Salve, churrasqueiro! 🍖 Me conta como será o seu evento que eu planejo tudo pra você.
                    </div>
                </div>

                <form id="chat-form" class="flex items-end gap-3 border-t border-stone-800 p-4">
                    <textarea id="chat-input" rows="2" placeholder="Descreva seu churrasco..."
                        class="flex-1 resize-none rounded-2xl border border-stone-800 bg-stone-950 px-4 py-3 text-sm text-stone-100 placeholder-stone-600 focus:border-orange-600 focus:outline-none"></textarea>
                    <button type="submit"
                        class="rounded-2xl bg-gradient-to-r from-orange-600 to-amber-500 px-5 py-3 font-bold text-stone-950 shadow-lg shadow-orange-950/50 transition hover:brightness-110 disabled:opacity-50">
                        Enviar
                    </button>
                </form>
            </section>
        </div>

        <script>
            const form = document.getElementById('chat-form');
            const input = document.getElementById('chat-input');
            const messages = document.getElementById('messages');

            const bubble = (text, mine) => {
                const el = document.createElement('div');
                el.className = mine
                    ? 'max-w-[85%] self-end rounded-2xl rounded-br-md bg-orange-600/90 px-4 py-3 text-sm text-stone-950 whitespace-pre-wrap'
                    : 'md max-w-[85%] self-start rounded-2xl rounded-bl-md border border-stone-800 bg-stone-950 px-4 py-3 text-sm text-stone-300';
                if (mine) {
                    el.textContent = text;
                } else {
                    el.innerHTML = marked.parse(text);
                }
                messages.appendChild(el);
                messages.scrollTop = messages.scrollHeight;
                return el;
            };

            form.addEventListener('submit', async (e) => {
                e.preventDefault();
                const message = input.value.trim();
                if (!message) return;

                bubble(message, true);
                input.value = '';
                const waiting = bubble('Acendendo o carvão... 🔥', false);

                try {
                    const res = await fetch('{{ route('chat') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({ message }),
                    });
                    const data = await res.json();
                    waiting.innerHTML = marked.parse(data.reply ?? data.error ?? 'Resposta inesperada.');
                } catch (err) {
                    waiting.textContent = 'Não foi possível conectar ao servidor.';
                }
            });
        </script>
    </body>
</html>
