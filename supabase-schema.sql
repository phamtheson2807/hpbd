-- Bảng birthdays hiện tại đang trống và dùng cấu trúc cũ.
-- Tạo lại bảng để bảo đảm cấu trúc khớp với website.
drop table if exists public.birthdays cascade;

create table public.birthdays (
    id text primary key
        check (id ~ '^[A-Za-z0-9]{6}$'),
    data jsonb not null,
    created_at timestamptz not null default now()
);

alter table public.birthdays enable row level security;

create policy "Anyone can read birthdays"
on public.birthdays
for select
to anon
using (true);

create policy "Anyone can create birthdays"
on public.birthdays
for insert
to anon
with check (
    jsonb_typeof(data) = 'object'
    and length(coalesce(data->>'name', '')) between 1 and 100
    and length(coalesce(data->>'title', '')) between 1 and 200
    and jsonb_typeof(data->'wishes') = 'array'
);
