# Quick CSS Code Reference

## Key Animation Snippets

### Shine Animation (Product Cards)
```css
@keyframes shine {
    0% { transform: translateX(0) translateY(0); }
    50% { transform: translateX(100px) translateY(100px); }
    100% { transform: translateX(200px) translateY(200px); }
}

.product_card::before {
    animation: shine 8s infinite;
}
```

### Shimmer Animation (About Section)
```css
@keyframes shimmer {
    0% { left: -100%; }
    50% { left: 50%; }
    100% { left: 100%; }
}

.about-brand::before {
    animation: shimmer 3s infinite;
}
```

### Float Animation (CTA Heading)
```css
@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
}

.cta h2 {
    animation: float 3s ease-in-out infinite;
}
```

### Slide Right Animation (Review Card Border)
```css
@keyframes slideRight {
    0%, 100% { transform: translateX(-100%); }
    50% { transform: translateX(100%); }
}

.review-card::before {
    animation: slideRight 2s ease-in-out infinite;
}
```

## Hover State Examples

### Product Card Hover
```css
.product_card:hover {
    transform: translateY(-15px) scale(1.02);
    box-shadow: 0 20px 60px rgba(255, 153, 0, 0.3), 
                inset 0 0 30px rgba(255, 153, 0, 0.05);
    border-color: rgba(255, 153, 0, 0.5);
}

.product_card:hover .card-img-top {
    transform: scale(1.1) rotate(2deg);
}
```

### Testimonial Card Hover
```css
.person:hover {
    transform: translateY(-18px) scale(1.05);
    box-shadow: 0 30px 70px rgba(255, 153, 0, 0.35);
    border-color: rgba(255, 153, 0, 0.6);
}

.person:hover img {
    transform: scale(1.15) rotate(-5deg);
    border-color: rgba(255, 153, 0, 0.8);
}
```

### About Image Hover
```css
.about-brand img:hover {
    transform: scale(1.05) rotate(-2deg);
    box-shadow: 0 30px 80px rgba(255, 153, 0, 0.4);
}
```

## Button Styling

### Add to Cart Button
```css
.addtocart {
    background: linear-gradient(135deg, #ff9900, #ff6b6b);
    color: white;
    padding: 10px 15px;
    border: none;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.addtocart:hover {
    transform: scale(1.05);
    box-shadow: 0 8px 20px rgba(255, 153, 0, 0.4);
}
```

### View Details Button
```css
.viewbtn {
    background: transparent;
    color: #a1ffce;
    border: 2px solid #a1ffce;
    padding: 10px 15px;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.viewbtn:hover {
    background: #a1ffce;
    color: #0d0d0d;
    transform: scale(1.05);
}
```

## Gradient Backgrounds

### Featured Products Section
```css
.featured-products {
    background: linear-gradient(135deg, rgba(13, 13, 13, 0.5) 0%, rgba(20, 20, 20, 0.8) 100%);
    border-radius: 20px;
}
```

### About Brand Section
```css
.about-brand {
    background: linear-gradient(135deg, rgba(255, 153, 0, 0.05) 0%, rgba(161, 255, 206, 0.05) 100%);
    border: 1px solid rgba(255, 153, 0, 0.1);
}
```

### Review Card
```css
.review-card {
    background: linear-gradient(135deg, #1a1a1a 0%, #252525 100%);
    border: 1px solid rgba(255, 153, 0, 0.2);
}
```

## Section Title Styling

```css
.section-title {
    font-size: 3rem;
    color: #ff9900;
    position: relative;
    margin-bottom: 3rem;
}

.section-title::after {
    content: '';
    width: 100px;
    height: 4px;
    background: linear-gradient(to right, #ff9900, #a1ffce, #faffd1);
    display: block;
    margin: 20px auto 0;
    border-radius: 2px;
    animation: slideIn 0.8s ease-out;
}
```

## Responsive Adjustments

```css
/* Tablets */
@media (max-width: 768px) {
    .featured-products .section-title { font-size: 2rem; }
    .product_card { margin-bottom: 1rem; }
    .pcc_btns { flex-direction: column; }
}

/* Mobile */
@media (max-width: 480px) {
    .featured-products .section-title { font-size: 1.8rem; }
    .addtocart, .viewbtn { width: 100%; }
    .cta h2 { font-size: 1.5rem; }
}
```

## Color Variables Quick Reference

```
Primary Orange:    #ff9900
Accent Red:        #ff6b6b
Cyan Accent:       #a1ffce
Light Yellow:      #faffd1
Dark BG Primary:   #0d0d0d
Dark BG Secondary: #1a1a1a
Dark BG Tertiary:  #252525
Light Text:        #f4f4f4
Medium Text:       #ccc
Muted Text:        #999
```

---

All CSS is production-ready and optimized for performance! 🚀
