<?php
/**
 * Template Name: Build Your Own Box (Final Production)
 * Description: Exact UI Match with Real Data & Logic
 */

// =================================================================
// 1. PHP: FETCH REAL DATA
// =================================================================

// A. Get Categories for "Occasions"
$occasion_options = '<option value="">-- Choose an Occasion --</option>';
$terms = get_terms( array( 'taxonomy' => 'product_cat', 'hide_empty' => true, 'parent' => 0 ) );
if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
    foreach ( $terms as $term ) {
        $occasion_options .= '<option value="' . esc_attr( $term->slug ) . '">' . esc_html( $term->name ) . '</option>';
    }
}

// B. Get All Products for JS
$args = array( 'status' => 'publish', 'limit' => -1 );
$raw_products = wc_get_products( $args );
$js_products = array();

foreach ( $raw_products as $prod ) {
    $img_id = $prod->get_image_id();
    $img_url = $img_id ? wp_get_attachment_image_url( $img_id, 'woocommerce_thumbnail' ) : wc_placeholder_img_src();
    $cats = wp_get_post_terms( $prod->get_id(), 'product_cat', array('fields' => 'slugs') );
    
    // Logic: Food items usually cannot be branded directly
    $is_brandable = !in_array('food', $cats); 

    $js_products[] = array(
        'id'       => $prod->get_id(),
        'name'     => $prod->get_name(),
        'price'    => (float) $prod->get_price(),
        'image'    => $img_url,
        'cats'     => $cats,
        'branding' => $is_brandable 
    );
}
$json_products = json_encode( $js_products );
?>

<style>
    /* --- LAYOUT FIXES --- */
    :root .has-global-padding .wp-block-group__inner-container, 
    .entry-content, .wp-site-blocks { max-width: 100% !important; padding: 0 !important; }
    
    #giftara-app-wrapper { background-color: #fcfcfc; min-height: 800px; font-family: 'Inter', sans-serif; }
    .giftara-container { max-width: 1300px; margin: 0 auto; padding: 40px 20px; }

    /* --- COLORS --- */
    :root { --g-pink: #e256b9; --g-yellow: #FFB703; --g-dark: #2c2c2c; --g-light: #f8f9fa; }

    /* --- WIZARD --- */
    .step-wizard { display: flex; justify-content: space-between; margin-bottom: 40px; position: relative; }
    .step-wizard::before { content: ''; position: absolute; top: 15px; left: 0; right: 0; height: 2px; background: #e0e0e0; z-index: 0; }
    .step-item { position: relative; z-index: 1; text-align: center; background: #fcfcfc; padding: 0 10px; width: 20%; }
    .step-circle { width: 34px; height: 34px; line-height: 34px; background: #e0e0e0; color: #777; border-radius: 50%; margin: 0 auto 8px; font-weight: bold; transition: 0.3s; }
    .step-label { font-size: 12px; color: #999; font-weight: 600; text-transform: uppercase; }
    .step-item.active .step-circle { background: var(--g-pink); color: #fff; transform: scale(1.1); box-shadow: 0 0 0 4px rgba(226, 86, 185, 0.2); }
    .step-item.active .step-label { color: var(--g-pink); }
    .step-item.complete .step-circle { background: var(--g-dark); color: #fff; }

    /* --- LAYOUT --- */
    .app-row { display: flex; flex-wrap: wrap; margin: -15px; }
    .app-col-sidebar { width: 25%; padding: 15px; }
    .app-col-main { width: 75%; padding: 15px; }
    @media(max-width: 991px) { .app-col-sidebar, .app-col-main { width: 100%; } }

    /* --- SIDEBAR --- */
    .sidebar-card { background: #fff; border: 1px solid #eee; border-radius: 12px; padding: 25px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); position: sticky; top: 30px; }
    .budget-track { height: 6px; background: #eee; border-radius: 3px; overflow: hidden; margin: 15px 0 5px; }
    .budget-fill { height: 100%; width: 0%; background: var(--g-yellow); transition: 0.3s; }
    .box-list { list-style: none; padding: 0; margin: 0; max-height: 200px; overflow-y: auto; border-top: 1px solid #eee; padding-top: 10px; }
    .box-list li { display: flex; justify-content: space-between; font-size: 13px; margin-bottom: 8px; color: #555; }
    #box-canvas { width: 100%; height: 180px; background: #f0f2f5; border-radius: 8px; }

    /* --- MAIN CARD --- */
    .main-card { background: #fff; border: 1px solid #eee; border-radius: 12px; padding: 40px; min-height: 500px; display: flex; flex-direction: column; }
    .step-title { font-size: 24px; font-weight: 700; color: var(--g-pink); margin-bottom: 10px; }
    
    /* Inputs */
    .big-input-card { background: #fcfcfc; border: 2px solid #eee; padding: 20px; border-radius: 8px; }
    .form-control-lg { height: 50px; font-size: 16px; border-radius: 6px; border: 1px solid #ddd; width: 100%; padding: 0 15px; }

    /* Packaging Grid */
    .pkg-grid { display: flex; gap: 20px; }
    .pkg-card { flex: 1; border: 2px solid #eee; border-radius: 10px; overflow: hidden; cursor: pointer; transition: 0.2s; }
    .pkg-card:hover { transform: translateY(-5px); box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
    .pkg-card.selected { border-color: var(--g-pink); background: #fff5fa; }
    .pkg-img { height: 160px; width: 100%; object-fit: cover; }

    /* Product Grid */
    .prod-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; max-height: 600px; overflow-y: auto; }
    .prod-card { border: 1px solid #eee; border-radius: 8px; padding: 10px; text-align: center; }
    .qty-btn { width: 25px; height: 25px; background: #fff; border: 1px solid #ddd; cursor: pointer; }

    /* Final Review Section Styles */
    .review-section { display: flex; flex-wrap: wrap; gap: 30px; }
    .review-left { flex: 1; }
    .review-right { flex: 1; background: #fcfcfc; padding: 25px; border-radius: 12px; border: 1px solid #eee; }
    
    .review-row { display: flex; margin-bottom: 15px; border-bottom: 1px dashed #eee; padding-bottom: 10px; }
    .review-label { font-weight: 600; width: 120px; color: #555; }
    .review-val { font-weight: 700; color: #000; flex: 1; }
    
    .prod-summary-item { display: flex; margin-bottom: 10px; border-bottom: 1px solid #f0f0f0; padding-bottom: 10px; }
    .prod-thumb { width: 50px; height: 50px; object-fit: cover; border-radius: 4px; border: 1px solid #ddd; margin-right: 15px; }
    
    .cost-row { display: flex; justify-content: space-between; margin-bottom: 5px; font-size: 15px; }
    .cost-total-display { font-size: 32px; font-weight: 800; color: var(--g-pink); margin-top: 5px; }

    /* Buttons */
    .btn-next { background: var(--g-pink); color: #fff; padding: 12px 30px; border-radius: 30px; border: none; font-weight: bold; cursor: pointer; }
    .btn-next:disabled { background: #ccc; cursor: not-allowed; }
    .btn-prev { background: transparent; color: #777; border: 1px solid #ddd; padding: 12px 30px; border-radius: 30px; font-weight: bold; cursor: pointer; }
    .btn-action { width: 100%; padding: 12px; border-radius: 6px; font-weight: bold; margin-bottom: 10px; cursor: pointer; border:none; }
    .btn-sample { background: #fff; border: 2px solid #ccc; color: #333; }
    .btn-order { background: #dc3545; color: #fff; }

    /* Modals CSS */
    .success-icon-container { display: flex; justify-content: center; align-items: center; margin-bottom: 20px; }
    .success-checkmark { width: 80px; height: 80px; background: #28a745; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 40px; box-shadow: 0 0 20px rgba(40, 167, 69, 0.4); }
    .modal-success-title { color: var(--g-pink); font-weight: 800; font-size: 2rem; margin-bottom: 10px; }
    .modal-success-text { font-size: 1.1rem; color: #666; margin-bottom: 30px; }
    .modal-backdrop { z-index: 1040; }
    .modal { z-index: 1050; }
    
    @media(max-width: 768px) { .pkg-grid, .prod-grid, .review-section { flex-direction: column; display: flex; } }
</style>

<div id="giftara-app-wrapper">
    <div class="giftara-container">
        
        <div class="text-center mb-5">
            <h1 style="font-weight: 800; color: #333;">Build-Your-Own Gift Box</h1>
            <p style="color: #666;">Design your perfect corporate gifting campaign in 5 easy steps.</p>
        </div>

        <div class="step-wizard">
            <div class="step-item active" id="nav-step-1"><div class="step-circle">1</div><div class="step-label">Budget</div></div>
            <div class="step-item" id="nav-step-2"><div class="step-circle">2</div><div class="step-label">Packaging</div></div>
            <div class="step-item" id="nav-step-3"><div class="step-circle">3</div><div class="step-label">Products</div></div>
            <div class="step-item" id="nav-step-4"><div class="step-circle">4</div><div class="step-label">Branding</div></div>
            <div class="step-item" id="nav-step-5"><div class="step-circle">5</div><div class="step-label">Preview</div></div>
        </div>

        <div class="app-row">
            <div class="app-col-sidebar">
                <div class="sidebar-card">
                    <h4 style="font-size: 18px; font-weight: 700; margin-bottom: 20px; border-bottom: 2px solid #f0f0f0; padding-bottom: 10px;">Box Summary</h4>
                    <div class="summary-row"><span>Total Budget:</span><span id="txt-budget">₹1,000</span></div>
                    <div class="summary-row"><span>Remaining:</span><span style="color:var(--g-pink)" id="txt-remaining">₹1,000</span></div>
                    <div class="budget-track"><div class="budget-fill" id="bar-budget"></div></div>
                    <div class="budget-msg text-success" id="msg-budget">Within Budget</div>
                    <h5 style="font-size: 14px; font-weight: 700; margin-top: 20px;">Contents (<span id="count-items">0</span>)</h5>
                    <ul class="box-list" id="list-items"><li style="font-style: italic;">Start by setting budget...</li></ul>
                    <div id="box-3d-wrapper" style="display:none; margin-top:15px;">
                        <hr>
                        <div style="display:flex; justify-content:space-between; margin-bottom:10px;">
                            <span style="font-weight:bold; font-size:12px;">3D Preview</span>
                            <div><button class="btn btn-sm btn-light border" onclick="app.toggleBox('closed')">Close</button> <button class="btn btn-sm btn-light border" onclick="app.toggleBox('open')">Open</button></div>
                        </div>
                        <div id="box-canvas"></div>
                        <small class="text-muted d-block text-center mt-1">Drag to rotate</small>
                    </div>
                </div>
            </div>

            <div class="app-col-main">
                <div class="main-card">
                    <div id="step-content-area"><div style="text-align:center; padding: 50px;"><i class="fas fa-circle-notch fa-spin fa-3x" style="color:var(--g-pink)"></i></div></div>
                    <div class="nav-footer" style="margin-top:auto; padding-top:30px; display:flex; justify-content:space-between; border-top:1px solid #eee;">
                        <button class="btn-prev" id="btn-prev" style="display:none;">Previous</button>
                        <button class="btn-next" id="btn-next">Next Step &rarr;</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="border-radius: 1rem;">
            <div class="modal-body p-5 text-center">
                <div class="success-icon-container">
                    <div class="success-checkmark"><i class="fa-solid fa-check"></i></div>
                </div>
                <h2 class="modal-success-title">Order Received!</h2>
                <p class="modal-success-text">Thank you for your request. We have received your custom box details and will get back to you shortly via email.</p>
                <div class="d-flex justify-content-center gap-3 mt-4">
                    <a href="<?php echo home_url(); ?>" class="btn btn-outline-secondary rounded-pill px-4 fw-bold"><i class="fa-solid fa-house me-2"></i> Go Home</a>
                    <button type="button" class="btn btn-giftara-primary rounded-pill px-4 fw-bold" onclick="window.location.reload();"><i class="fa-solid fa-rotate-right me-2"></i> Order Another Custom Gift</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade login-modal" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="position: absolute; right: 15px; top: 10px; border: none; background: none; font-size: 24px;">&times;</button>
            <div class="modal-header border-0 pb-0 justify-content-center">
                <div class="text-center">
                    <h2 class="modal-brand" style="color:var(--g-pink);">The Giftara</h2>
                    <p class="modal-subtitle text-muted">Log In to Your Account</p>
                </div>
            </div>
            <div class="modal-body pt-3">
                <div class="form-validation-alert alert alert-danger" style="display:none;" role="alert"></div>
                <form id="login-form-custom">
                    <div class="form-group mb-3">
                        <label>Username or Email</label>
                        <input type="text" class="form-control" name="username" required placeholder="name@example.com" />
                    </div>
                    <div class="form-group mb-3">
                        <label>Password</label>
                        <input type="password" class="form-control" name="password" required placeholder="Password" />
                    </div>
                    <button type="submit" class="btn btn-giftara-primary w-100 mb-3" style="background:var(--g-pink); color:#fff;">Log in</button>
                </form>
                <div class="text-center">
                    <p class="footer-text mb-0">New here? <a href="#" data-dismiss="modal" data-toggle="modal" data-target="#SignupModal">Create an account</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade login-modal" id="SignupModal" tabindex="-1" aria-labelledby="SignupModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="position: absolute; right: 15px; top: 10px; border: none; background: none; font-size: 24px;">&times;</button>
            <div class="modal-header border-0 pb-0 justify-content-center">
                <div class="text-center">
                    <h2 class="modal-brand" style="color:var(--g-pink);">The Giftara</h2>
                    <p class="modal-subtitle text-muted">Create Your Free Account</p>
                </div>
            </div>
            <div class="modal-body pt-3">
                <div class="form-validation-alert alert alert-danger" style="display:none;" role="alert"></div>
                <form id="register-form-custom">
                    <div class="form-group mb-3">
                        <label>Full Name</label>
                        <input type="text" class="form-control" name="fullname" required />
                    </div>
                    <div class="form-group mb-3">
                        <label>Email</label>
                        <input type="email" class="form-control" name="email" required />
                    </div>
                    <div class="form-group mb-3">
                        <label>Password</label>
                        <input type="password" class="form-control" name="password" required />
                    </div>
                    <button type="submit" class="btn btn-giftara-primary w-100 mb-3" style="background:var(--g-pink); color:#fff;">Register</button>
                </form>
                <div class="text-center">
                    <p class="footer-text mb-0">Already have an account? <a href="#" data-dismiss="modal" data-toggle="modal" data-target="#loginModal">Login</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
jQuery(document).ready(function($) {
    
    // --- DATA ---
    const DB_PRODUCTS = <?php echo $json_products; ?>;
    const PACKAGING = [
        { id: 1, name: "Eco-Friendly Kraft Box", price: 150, img: "https://thegiftara.com/wp-content/uploads/2025/12/eco-frendly.jpeg", color: 0xD2B48C, size: [2.5, 1.5, 2.5] },
        { id: 2, name: "Premium Pink Box", price: 300, img: "https://thegiftara.com/wp-content/uploads/2025/12/premium-box.jpeg", color: 0xD81E5B, size: [2.2, 1.2, 2.2] },
        { id: 3, name: "Luxury Grey Velvet", price: 500, img: "https://thegiftara.com/wp-content/uploads/2025/12/luxery-box.jpeg", color: 0x4A4A4A, size: [3.0, 1.5, 2.0] }
    ];

    // --- STATE ---
    window.app = {
        step: 1, budget: 1000, remaining: 1000, occasion: '', box: null, items: [], logo: null, view: 'closed', orderQty: 20
    };

    // --- INIT ---
    renderStep();
    updateSummary();

    // --- RENDER LOGIC ---
    function renderStep() {
        // Wizard UI
        $('.step-item').removeClass('active complete');
        for(let i=1; i<=5; i++) {
            if(i < app.step) $(`#nav-step-${i}`).addClass('complete');
            if(i === app.step) $(`#nav-step-${i}`).addClass('active');
        }
        $('#btn-prev').toggle(app.step > 1);
        $('#btn-next').toggle(app.step < 5);
        validateStep();

        const area = $('#step-content-area');
        
        // --- STEP 1: BUDGET ---
        if(app.step === 1) {
            const occOpts = `<?php echo $occasion_options; ?>`;
            area.html(`
                <div class="step-title">Step 1: Set Budget & Occasion</div>
                <p class="step-desc">Define the total budget per box and the occasion.</p>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="big-input-card">
                            <label class="big-input-label">Total Budget per Box (₹)</label>
                            <input type="number" id="inp-budget" value="${app.budget}" min="1000" class="form-control-lg">
                            <small class="text-muted">Minimum ₹1000</small>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="big-input-card">
                            <label class="big-input-label">Select Occasion</label>
                            <select id="inp-occasion" class="form-control-lg">${occOpts}</select>
                        </div>
                    </div>
                </div>
            `);
            $('#inp-budget').on('change', function(){ 
                let val = parseInt($(this).val());
                if(val < 1000 || isNaN(val)) { 
                    alert("Minimum budget is ₹1000"); 
                    val = 1000; $(this).val(1000); 
                }
                app.budget = val; calculate(); validateStep();
            });
            $('#inp-occasion').val(app.occasion).on('change', function(){
                app.occasion = $(this).val(); validateStep();
            });
        }

        // --- STEP 2: PACKAGING ---
        else if(app.step === 2) {
            let html = `<div class="step-title">Step 2: Choose Packaging</div>
                        <p class="step-desc">Select the perfect box. Cost deducted from budget.</p>
                        <div class="pkg-grid">`;
            PACKAGING.forEach(p => {
                let active = app.box && app.box.id === p.id ? 'selected' : '';
                html += `<div class="pkg-card ${active}" onclick="app.selectBox(${p.id})">
                        <img src="${p.img}" class="pkg-img">
                        <div class="pkg-info"><div>${p.name}</div><div style="color:var(--g-pink)">₹${p.price}</div></div>
                    </div>`;
            });
            html += `</div>`;
            area.html(html);
        }

        // --- STEP 3: PRODUCTS ---
        else if(app.step === 3) {
            let products = DB_PRODUCTS;
            if(app.occasion) {
                let filtered = products.filter(p => p.cats.includes(app.occasion));
                if(filtered.length > 0) products = filtered;
            }
            let html = `<div class="step-title">Step 3: Add Products to the Box</div>
                        <p class="step-desc">Select products to fill your box. Showing products for occasion: <b>${app.occasion || 'All'}</b>.</p>
                        <h5 class="mb-3 text-primary font-weight-bold">Product Budget Remaining: ₹${app.remaining.toLocaleString('en-IN')}</h5>
                        <div class="prod-grid">`;
            
            products.forEach(p => {
                let inCart = app.items.find(x => x.id === p.id);
                let qty = inCart ? inCart.qty : 0;
                html += `<div class="prod-card">
                        <div class="prod-img-wrap"><img src="${p.image}" class="prod-img"></div>
                        <div class="prod-title">${p.name}</div>
                        <div style="font-size:12px; color:#777; margin-bottom:5px;">₹${p.price}</div>
                        <div class="qty-ctrl"><button class="qty-btn" onclick="app.modQty(${p.id}, -1)">-</button>
                        <span style="font-weight:bold;">${qty}</span><button class="qty-btn" onclick="app.modQty(${p.id}, 1)">+</button></div>
                    </div>`;
            });
            html += `</div>`;
            area.html(html);
        }

        // --- STEP 4: BRANDING (SPLIT VIEW) ---
        else if(app.step === 4) {
            let brandedList = app.items.filter(i => {
                let p = DB_PRODUCTS.find(x => x.id === i.id);
                return p.branding === true;
            });
            let unbrandedList = app.items.filter(i => {
                let p = DB_PRODUCTS.find(x => x.id === i.id);
                return p.branding === false;
            });

            let brandedHtml = brandedList.length ? brandedList.map(i => `<li>${i.name} (x${i.qty})</li>`).join('') : '<li class="text-muted">No branding capable items selected.</li>';
            let unbrandedHtml = unbrandedList.length ? unbrandedList.map(i => `<li>${i.name} (x${i.qty})</li>`).join('') : '<li class="text-muted">None.</li>';

            area.html(`
                <div class="step-title">Step 4: Upload Company Logo (Branding)</div>
                <div class="row">
                    <div class="col-md-6">
                        <div style="text-align:center; padding: 40px; border: 2px dashed #ddd; border-radius: 10px; background: #fafafa;">
                            <i class="fas fa-cloud-upload-alt fa-3x" style="color:#ccc; margin-bottom:20px;"></i>
                            <h4>Upload Logo</h4>
                            <input type="file" id="inp-logo" class="form-control" style="width: 80%; margin: 20px auto;">
                            <div id="logo-status" class="text-success font-weight-bold">${app.logo ? 'Logo Uploaded' : ''}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 border rounded bg-light h-100">
                            <h6 style="color:var(--g-pink); font-weight:bold;">Items to be Branded:</h6>
                            <ul class="mb-4 pl-3 small">${brandedHtml}</ul>
                            <h6 style="color:#333; font-weight:bold;">Items Without Branding:</h6>
                            <ul class="pl-3 small">${unbrandedHtml}</ul>
                        </div>
                    </div>
                </div>
            `);
            $('#inp-logo').on('change', function(e){
                if(e.target.files[0]) {
                    app.logo = e.target.files[0];
                    $('#logo-status').text("Logo Uploaded: " + app.logo.name);
                }
            });
        }

        // --- STEP 5: PREVIEW & ORDER (FINAL LAYOUT) ---
        else if(app.step === 5) {
            let prodListHtml = '';
            let totalBoxCost = (app.box ? app.box.price : 0);
            
            app.items.forEach(i => {
                let pData = DB_PRODUCTS.find(x => x.id === i.id);
                totalBoxCost += (pData.price * i.qty);
                prodListHtml += `
                    <div class="prod-summary-item">
                        <img src="${pData.image}" class="prod-thumb">
                        <div style="flex:1">
                            <div style="font-weight:bold; font-size:14px;">${i.name}</div>
                            <div style="font-size:12px; color:#777;">Qty: ${i.qty} | Standard</div>
                        </div>
                        <div style="font-weight:bold;">₹${(pData.price * i.qty).toLocaleString('en-IN')}</div>
                    </div>
                `;
            });

            let campaignCost = totalBoxCost * app.orderQty;

            area.html(`
                <div class="step-title">Step 5: Preview & Order Confirmation</div>
                <p class="step-desc">Review your final box design and confirm the campaign or request a physical sample.</p>
                
                <div class="review-section">
                    <div class="review-left">
                        <h5 style="border-bottom:1px solid #eee; padding-bottom:10px; margin-bottom:20px;">Final Box Configuration</h5>
                        <div class="review-row"><div class="review-label">Occasion:</div><div class="review-val">${app.occasion}</div></div>
                        <div class="review-row"><div class="review-label">Packaging:</div><div class="review-val">${app.box.name} (₹${app.box.price})</div></div>
                        <div class="review-row"><div class="review-label">Branding:</div><div class="review-val">${app.logo ? 'Logo Uploaded' : 'No Logo'}</div></div>
                        
                        <h6 class="mt-4 mb-3" style="font-weight:bold;">Selected Products:</h6>
                        <div style="max-height:300px; overflow-y:auto;">${prodListHtml}</div>
                    </div>

                    <div class="review-right">
                        <div class="cost-row"><span>Cost Per Box:</span><strong style="font-size:18px;">₹${totalBoxCost.toLocaleString('en-IN')}</strong></div>
                        <div class="cost-row" style="color:#777;"><span>Budget Per Box:</span><span>₹${app.budget.toLocaleString('en-IN')}</span></div>
                        <div class="cost-row" style="color:var(--g-pink); margin-top:10px;"><span>Remaining Budget (Per Box):</span><strong>₹${app.remaining.toLocaleString('en-IN')}</strong></div>
                        <hr>
                        <div class="form-group">
                            <label style="font-weight:bold;">Order Campaign Quantity (Minimum 20)</label>
                            <input type="number" id="inp-final-qty" value="${app.orderQty}" class="form-control">
                            <small class="text-muted">Total cost includes all boxes and contents multiplied by the quantity.</small>
                        </div>
                        <div class="p-3 bg-light rounded text-center mb-3">
                            <div style="font-size:12px; font-weight:bold; color:#555;">Total Campaign Cost</div>
                            <div class="cost-total-display" id="final-total">₹${campaignCost.toLocaleString('en-IN')}</div>
                        </div>
                        
                        <div style="display:flex; gap:10px;">
                            <button class="btn-action btn-sample" onclick="app.processAction('sample')">Get Sample (1 Box)</button>
                            <button class="btn-action btn-order" id="btn-final-order" onclick="app.processAction('order')">Order Confirmation</button>
                        </div>
                    </div>
                </div>
            `);

            $('#inp-final-qty').on('blur', function(){
                let val = parseInt($(this).val()) || 0;
                if(val < 20) {
                    alert("Order Campaign Quantity must be at least 20.");
                    val = 20;
                    $(this).val(20);
                }
                app.orderQty = val;
                $('#final-total').text('₹' + (totalBoxCost * val).toLocaleString('en-IN'));
            });
            
            // Immediate update on type
            $('#inp-final-qty').on('input', function(){
                let val = parseInt($(this).val()) || 0;
                $('#final-total').text('₹' + (totalBoxCost * val).toLocaleString('en-IN'));
            });
        }
    }

    // --- LOGIC FUNCTIONS ---
    app.selectBox = function(id) {
        let b = PACKAGING.find(x => x.id === id);
        if(b.price > app.budget) { alert("Too expensive!"); return; }
        app.box = b; calculate(); renderStep();
    };

    app.modQty = function(pid, delta) {
        let prod = DB_PRODUCTS.find(x => x.id === pid);
        let exist = app.items.find(x => x.id === pid);
        if(delta > 0) {
            if(app.remaining < prod.price) { alert("Budget Exceeded!"); return; }
            if(!exist) app.items.push({id: pid, name: prod.name, price: prod.price, qty: 1}); else exist.qty++;
        } else {
            if(exist) { exist.qty--; if(exist.qty <= 0) app.items = app.items.filter(x => x.id !== pid); }
        }
        calculate(); renderStep();
    };

    app.processAction = function(type) {
        // CHECK LOGIN STATUS
        const isLoggedIn = <?php echo is_user_logged_in() ? 'true' : 'false'; ?>;
        
        if(!isLoggedIn) {
            $('#loginModal').modal('show');
            return;
        }

        // AJAX SUBMIT
        let btn = type === 'sample' ? $('.btn-sample') : $('.btn-order');
        let oldText = btn.text();
        btn.text('Processing...').prop('disabled', true);

        // Use FormData to handle potential file uploads
        let formData = new FormData();
        formData.append('action', 'giftara_send_order_emails');
        formData.append('nonce', giftara_ajax_object.nonce);
        formData.append('type', type);
        formData.append('order_data', JSON.stringify(app));
        if(app.logo) formData.append('company_logo', app.logo);

        $.ajax({
            url: giftara_ajax_object.ajax_url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(res) {
                if(res.success) {
                    $('#successModal').modal('show');
                } else {
                    alert(res.data.message || "Error processing request.");
                }
                btn.text(oldText).prop('disabled', false);
            },
            error: function() {
                alert("Server Error.");
                btn.text(oldText).prop('disabled', false);
            }
        });
    };

    function calculate() {
        let boxCost = app.box ? app.box.price : 0;
        let prodCost = app.items.reduce((s,i) => s + (i.price * i.qty), 0);
        app.remaining = app.budget - (boxCost + prodCost);
        updateSummary();
    }

    function updateSummary() {
        $('#txt-budget').text('₹' + app.budget.toLocaleString('en-IN'));
        $('#txt-remaining').text('₹' + app.remaining.toLocaleString('en-IN'));
        $('#count-items').text(app.items.reduce((s,i)=>s+i.qty, 0));
        let pct = ((app.budget - app.remaining) / app.budget) * 100;
        $('#bar-budget').css('width', pct + '%');
        
        let html = '';
        if(app.box) html += `<li><span>${app.box.name}</span><strong>₹${app.box.price}</strong></li>`;
        app.items.forEach(i => html += `<li><span>${i.name} x${i.qty}</span><strong>₹${i.price*i.qty}</strong></li>`);
        $('#list-items').html(html || '<li style="font-style:italic;">Empty...</li>');

        if(app.box) { $('#box-3d-wrapper').show(); render3D(); }
    }

    function validateStep() {
        let valid = false;
        if(app.step===1 && app.budget>=1000 && app.occasion) valid=true;
        if(app.step===2 && app.box) valid=true;
        if(app.step===3 && app.items.length > 0) valid=true; // Must select at least 1 product
        if(app.step===4) valid=true;
        if(app.step===5) valid=false; 
        $('#btn-next').prop('disabled', !valid);
    }

    $('#btn-next').click(() => { app.step++; renderStep(); });
    $('#btn-prev').click(() => { app.step--; renderStep(); });

    // --- 3D PREVIEW (Three.js) ---
    let scene, camera, renderer, boxMesh, lidMesh;
    function render3D() {
        if(!renderer) {
            const container = document.getElementById('box-canvas');
            scene = new THREE.Scene(); scene.background = new THREE.Color(0xf0f2f5);
            camera = new THREE.PerspectiveCamera(45, container.offsetWidth/container.offsetHeight, 0.1, 1000);
            camera.position.set(0, 2, 5);
            renderer = new THREE.WebGLRenderer({ antialias: true });
            renderer.setSize(container.offsetWidth, container.offsetHeight);
            container.appendChild(renderer.domElement);
            scene.add(new THREE.DirectionalLight(0xffffff, 1));
            scene.add(new THREE.AmbientLight(0xffffff, 0.6));
            requestAnimationFrame(animate3D);
        }
        if(!app.box) return;
        if(boxMesh) scene.remove(boxMesh); if(lidMesh) scene.remove(lidMesh);
        const color = app.box.color; const [w, h, d] = app.box.size;
        const mat = new THREE.MeshLambertMaterial({ color: color });
        boxMesh = new THREE.Mesh(new THREE.BoxGeometry(w, h, d), mat);
        scene.add(boxMesh);
        lidMesh = new THREE.Mesh(new THREE.BoxGeometry(w+0.1, 0.1, d+0.1), mat);
        lidMesh.position.set(0, h/2 + 0.05, 0);
        if(app.view === 'open') { lidMesh.position.set(0, h/2 + 1, -1); lidMesh.rotation.x = -Math.PI / 4; }
        scene.add(lidMesh);
    }
    app.toggleBox = function(s) { app.view = s; render3D(); };
    function animate3D() { requestAnimationFrame(animate3D); if(boxMesh) { boxMesh.rotation.y += 0.005; lidMesh.rotation.y += 0.005; } renderer.render(scene, camera); }

    // LOGIN & REGISTER FORMS AJAX
    $('#giftara-login-form').submit(function(e){
        e.preventDefault();
        $.post(giftara_ajax_object.ajax_url, {
            action: 'giftara_ajax_login',
            security: '<?php echo wp_create_nonce("woocommerce-login"); ?>',
            username: $(this).find('[name="username"]').val(),
            password: $(this).find('[name="password"]').val()
        }, function(res){
            if(res.success) { location.reload(); } else { alert(res.data.message || "Login failed"); }
        });
    });

    $('#register-form-custom').submit(function(e){
        e.preventDefault();
        $.post(giftara_ajax_object.ajax_url, {
            action: 'giftara_ajax_register',
            security: '<?php echo wp_create_nonce("woocommerce-register"); ?>',
            fullname: $(this).find('[name="fullname"]').val(),
            username: $(this).find('[name="username"]').val(),
            email: $(this).find('[name="email"]').val(),
            password: $(this).find('[name="password"]').val()
        }, function(res){
            if(res.success) { location.reload(); } else { alert(res.data.message || "Registration failed"); }
        });
    });
});
</script>