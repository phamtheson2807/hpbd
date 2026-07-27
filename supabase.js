const SUPABASE_URL = 'https://fwyhizshtacywojeyxsx.supabase.co';
const SUPABASE_KEY = 'sb_publishable_AO9n_07uzNP-vP2EqoW7Mw_qetQWxRN';
const BIRTHDAYS_ENDPOINT = `${SUPABASE_URL}/rest/v1/birthdays`;

async function saveBirthday(id, data) {
    const response = await fetch(BIRTHDAYS_ENDPOINT, {
        method: 'POST',
        headers: {
            apikey: SUPABASE_KEY,
            Authorization: `Bearer ${SUPABASE_KEY}`,
            'Content-Type': 'application/json',
            Prefer: 'return=minimal'
        },
        body: JSON.stringify({ id, data })
    });

    if (!response.ok) {
        const error = await response.json().catch(() => ({}));
        const requestError = new Error(error.message || 'Không thể lưu dữ liệu lên Supabase.');
        requestError.status = response.status;
        requestError.code = error.code;
        throw requestError;
    }
}

async function getBirthday(id) {
    const response = await fetch(
        `${BIRTHDAYS_ENDPOINT}?id=eq.${encodeURIComponent(id)}&select=data&limit=1`,
        {
            headers: {
                apikey: SUPABASE_KEY,
                Authorization: `Bearer ${SUPABASE_KEY}`
            }
        }
    );

    if (!response.ok) {
        const error = await response.json().catch(() => ({}));
        throw new Error(error.message || 'Không thể tải dữ liệu từ Supabase.');
    }

    const rows = await response.json();
    return rows.length > 0 ? rows[0].data : null;
}
