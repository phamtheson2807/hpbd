create table if not exists public.birthdays (
    id text primary key
        check (id ~ '^[A-Za-z0-9]{6}$'),
    data jsonb not null,
    created_at timestamptz not null default now()
);

-- Nâng cấp an toàn nếu bảng birthdays cũ đã tồn tại với các cột
-- name, age, date, title, wishes thay vì cột JSONB data.
alter table public.birthdays
add column if not exists data jsonb;

update public.birthdays
set data = to_jsonb(birthdays) - 'data' - 'created_at'
where data is null;

alter table public.birthdays
alter column data set not null;

alter table public.birthdays enable row level security;

drop policy if exists "Anyone can read birthdays" on public.birthdays;
drop policy if exists "Anyone can create birthdays" on public.birthdays;

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
