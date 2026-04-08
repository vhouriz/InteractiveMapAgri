<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Region 9 EXACT Province Shapes</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
<style>
/* Your existing styles remain the same */
body{margin:0;padding-top:100px;background:#f0f2f5;font-family:Arial, sans-serif;}
.navbar{background:white;border-bottom:1px solid #ddd;box-shadow:0 2px 10px rgba(0,0,0,0.1);}
.navbar-brand img{height:45px;margin-right:10px;}
.brand-text{line-height:1.1;}
.logonamev1{font-size:14px;font-weight:bold;color:#2f7d32;}
.logonamev2{font-size:12px;opacity:0.7;}
.map-card{width:95%;max-width:950px;margin:20px auto;background:white;border-radius:16px;padding:30px;box-shadow:0 15px 40px rgba(0,0,0,0.15);}
.map-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;}
.map-header h2{margin:0;font-size:28px;font-weight:700;color:#2f7d32;}
.map-subtitle{color:#666;font-size:15px;}
.map-header .btn{background:linear-gradient(145deg,#4CAF50,#388E3C);border:none;padding:10px 20px;border-radius:25px;font-weight:600;}
.tip-box{background:linear-gradient(90deg,#e8f5e8 0%,#f0f8f0 100%);border-left:5px solid #2f7d32;padding:15px 20px;border-radius:8px;margin:20px 0;font-size:14px;}
.legend-box{background:#f8f9fa;border:1px solid #e9ecef;border-radius:12px;padding:25px;margin:20px 0;}
.legend-grid{display:flex;justify-content:space-between;gap:30px;}
.legend-item{padding:15px;border-radius:8px;flex:1;}
.legend-provinces{background:#e8f5e8;border-left:4px solid #2f7d32;}
.map-wrapper{width:100%;height:650px;border:3px solid #333;border-radius:16px;overflow:hidden;margin:20px 0;box-shadow:0 8px 25px rgba(0,0,0,0.15);position:relative;}
#map{width:100%;height:100%;}
.info{position:absolute;top:20px;left:20px;z-index:1000;background:rgba(255,255,255,0.95);padding:15px;border-radius:10px;box-shadow:0 4px 20px rgba(0,0,0,0.2);border:1px solid rgba(0,0,0,0.1);font-weight:600;}
.province-glow{box-shadow:0 0 30px rgba(47,125,50,0.9)!important;transition:all 0.3s ease;}
#sideMenu {
    position: absolute;
    top: 80px;
    right: 20px;
    z-index: 1000;
    display: flex;
    flex-direction: column;
    gap: 10px;
    opacity: 0;
    pointer-events: none;
    transform: translateY(-10px);
    transition: 0.3s;
}
#sideMenu.show {
    opacity: 1;
    pointer-events: auto;
    transform: translateY(0);
}
</style>
</head>
<body>
<!-- Your navbar stays the same -->
<nav class="navbar navbar-expand-lg fixed-top">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center" href="#">
      <img src="pictures/Department_of_Agriculture_of_the_Philippines1.png">
      <div class="brand-text">
        <div class="logonamev1">DA RFO IX - Research</div>
        <div class="logonamev2">Real Province Shapes</div>
      </div>
    </a>
    <button id="menuToggle" class="btn btn-green" style="margin-left:auto;">☰</button>
    <div id="sideMenu">
      <button class="menu-btn">🏙️ Cities</button>
      <button class="menu-btn">💧 Irrigation</button>
      <button class="menu-btn">🌊 Baha</button>
    </div>
  </div>
</nav>

<div class="map-card">
  <!-- Your header stays the same -->
  <div class="map-header">
    <div><h2>🗺️ Region 9 Sample jutsu</h2><div class="map-subtitle">Real irregular outlines • No boxes • Green glow hover</div></div>
    <button class="btn btn-success" onclick="refreshMap()">🔄 Refresh</button>
    <button class="btn btn-primary" onclick="showIrrigation()">📍(unnderconstruction) Area of responsibility</button>
    <button class="btn btn-secondary" onclick="showAllProvinces()">🌍(underconstruction) Show All</button>
  </div>

  <div class="tip-box">🌾 <b>WATASHI</b> Sibugay, Del Norte, Del Sur → <span style="color:#2f7d32;font-weight:bold">SSSSS</span> • Hover = Green glow</div>

  <div class="legend-box">
    <div class="legend-grid">
      <div class="legend-item legend-provinces"><b>🌍 Sample</b><br></div>
    </div>
  </div>

  <!-- ✅ FIXED MAP WRAPPER - YIELD BELOW BUTTONS -->
  <div class="map-wrapper">
    <!-- Region Info - Top Left -->
    <div class="info" style="position: absolute; top: 15px; left: 15px; z-index: 1001; background: rgba(255,255,255,0.95); padding: 12px 16px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); backdrop-filter: blur(10px);">
      <b>🌾 Zamboanga Peninsula</b><br>
      <small>watashisisisi</small>
    </div>

    <!-- 🔥 TOGGLE BAR - BUTTONS FIRST, THEN YIELD -->
    <div id="mapButtons" style="position: absolute; top: 20px; right: 20px; z-index: 1002; width: 220px; background: rgba(255,255,255,0.98); padding: 15px; border-radius: 12px; box-shadow: 0 8px 32px rgba(0,0,0,0.15); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.3); display: none;">
      
      <!-- 1️⃣ ACTION BUTTONS (TOP - ALWAYS VISIBLE) -->
      <div style="margin-bottom: 12px; border-bottom: 1px solid #e9ecef; padding-bottom: 12px;">
        <button class="btn btn-danger mb-2 w-100 btn-sm py-1" onclick="goBack()">
          🔙 Back to Region
        </button>
        <button class="btn btn-primary mb-2 w-100 btn-sm py-1" onclick="showIrrigation()">
          💧 Irrigation
        </button>
        <button class="btn btn-warning w-100 btn-sm py-1" onclick="showBaha()">
          🌊 Baha Areas
        </button>
      </div>

      <!-- 🎨 SEPARATOR -->
      <div style="height: 8px; background: linear-gradient(90deg, transparent, #dee2e6 50%, transparent); margin: 8px 0;"></div>

      <!-- 2️⃣ YIELD DATA (BELOW BUTTONS - COMPACT) -->
      <div id="dataPanel" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); padding: 12px; border-radius: 8px; border-left: 4px solid #007bff; font-size: 13px;">
        <div id="panelTitle" style="margin: 0 0 8px 0; font-weight: 700; font-size: 14px; color: #333; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
          Municipality
        </div>
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
          <span style="color: #666; font-size: 12px;">Yield:</span>
          <span id="panelYield" style="font-weight: 700; color: #28a745; font-size: 15px; min-width: 60px; text-align: right;">-</span>
        </div>
        <div style="display: flex; justify-content: space-between; font-size: 12px; color: #666;">
          <span>Area:</span>
          <span id="panelArea" style="font-weight: 600;">0 ha</span>
        </div>
      </div>
    </div>

    <!-- Map -->
    <div id="map" style="width: 100%; height: 100%; border-radius: 12px;"></div>
  </div>
</div>

<!-- Your existing scripts stay EXACTLY the same -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
const map = L.map('map',{
    minZoom:9,
    maxZoom:18,
    maxBounds:L.latLngBounds([6.25,121.75],[8.75,123.85]),
    maxBoundsViscosity:1.0
}).setView([7.95,123.3],10);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

let provinceLayer;
function getColor(yieldValue) { 
    yieldValue = Number(yieldValue) || 0;
    if (yieldValue > 4.0) return "#1b5e20";
    if (yieldValue > 3.00) return "#ff1100";
    if (yieldValue > 2.00) return "#ddff00";
    if (yieldValue > 2.60) return "#a5d6a7";
    return "#e8f5e8";
}

function municipalityInteraction(feature, layer) {
    const name = feature.properties.Mun_Name || "Unknown";
    const yieldValue = Number(feature.properties.Mun_Yield) || 0;

    layer.setStyle({
        fillColor: getColor(yieldValue),
        fillOpacity: 0.7,
        color: "#333",
        weight: 1
    });

    layer.bindTooltip(`<b>${name}</b><br>Yield: ${yieldValue}`);

    layer.on({
        mouseover: function(e) {
            e.target.setStyle({
                weight: 3,
                color: "#2f7d32",
                fillOpacity: 0.9
            });
        },
        mouseout: function(e) {
            provinceLayer.resetStyle(e.target);
        },
        click: function() {
            // ✅ UPDATE YIELD DATA (NOW BELOW BUTTONS)
            document.getElementById("panelTitle").innerText = name;
            document.getElementById("panelYield").innerText = yieldValue.toFixed(1);
            document.getElementById("panelArea").innerText = "1,250 ha"; // Example
            
            // Show buttons panel
            document.getElementById("mapButtons").style.display = "block";

            // Your existing zoom logic...
            const fileName = name
                .toUpperCase()
                .normalize("NFD").replace(/[\u0300-\u036f]/g, "")
                .replace(/\$.*?\$/g, "")
                .replace(/CITY|MUNICIPALITY/gi, "")
                .replace(/[^A-Z0-9\s]/g, "")
                .trim()
                .replace(/\s+/g, "_") + ".geojson";

            fetch(`/geojson/${fileName}`)
            .then(res => {
                if (!res.ok) throw new Error("No file");
                return res.json();
            })
            .then(data => {
                if (provinceLayer) map.removeLayer(provinceLayer);
                provinceLayer = L.geoJSON(data, {
                    style: {
                        color: "#ff7800",
                        weight: 3,
                        fillColor: "#ffe0b2",
                        fillOpacity: 0.5
                    }
                }).addTo(map);
                map.fitBounds(provinceLayer.getBounds());
                map.setMaxBounds(provinceLayer.getBounds());
            })
            .catch(() => {
                alert("No GeoJSON for " + name);
            });
        }
    });
}

// Rest of your existing script stays the same...
fetch("/Region_9_municipalities.geojson")
.then(res => res.json())
.then(data => {
    provinceLayer = L.geoJSON(data, {
        style: {
            color: "#000000",
            weight: 2,
            fillColor: "#E8F5E8",
            fillOpacity: 0.3
        },
        onEachFeature: municipalityInteraction
    }).addTo(map);
    map.fitBounds(provinceLayer.getBounds());
});

function refreshMap() { location.reload(); }

function goBack() {
    if (provinceLayer) map.removeLayer(provinceLayer);
    fetch("{{ asset('Region_9_municipalities.geojson') }}")
    .then(res => res.json())
    .then(data => {
        provinceLayer = L.geoJSON(data, {
            style: {
                color: "#000000",
                weight: 2,
                fillColor: "#E8F5E8",
                fillOpacity: 0.3
            },
            onEachFeature: municipalityInteraction
        }).addTo(map);
        map.fitBounds(provinceLayer.getBounds());
        map.setMaxBounds(L.latLngBounds([6.25,121.75],[8.75,123.85]));
        document.getElementById("mapButtons").style.display = "none";
         clearIrrigation(map);
    });
}

let irrigationLayer;

function showIrrigation() {
    // Get selected municipality from panel
    const selectedMun = document.getElementById("panelTitle").innerText.trim();

    if (!selectedMun || selectedMun === "Municipality") {
        // Better UX feedback
        showNotification("Please click a municipality first!", "warning");
        return;
    }

    // Show loading state
    showNotification(`Loading irrigation data for ${selectedMun}...`, "info");

    // Remove old layer with fade effect
    if (irrigationLayer) {
        map.removeLayer(irrigationLayer);
        irrigationLayer = null;
    }

    fetch("{{ asset('geojson/Reg9_IrrigatedRiceAreas.geojson') }}")
    .then(res => res.json())
    .then(data => {
        console.log("GeoJSON Loaded:", data);

        irrigationLayer = L.geoJSON(data, {
            // 🔥 FILTER BY MUNICIPALITY NAME
            filter: function(feature) {
                const geoMun = (feature.properties.Mun_Name || "").toUpperCase().trim();
                return geoMun === selectedMun.toUpperCase();
            },

            // 🎨 BEAUTIFUL COLOR SCHEME
            style: function(feature) {
                return {
                    // Dynamic styling based on area size (if available)
                    color: getBorderColor(feature),
                    weight: 3,
                    opacity: 0.9,
                    fillColor: getFillColor(feature),
                    fillOpacity: 0.75,
                    dashArray: "5, 5", // Dashed border for style
                    lineJoin: "round",
                    lineCap: "round"
                };
            },

            // ✨ Enhanced popups with icons and stats
            onEachFeature: function(feature, layer) {
                const name = feature.properties.Mun_Name || "Unknown";
                const area = feature.properties?.Area_Ha || "N/A";
                
                const popupContent = `
                    <div style="min-width: 250px; font-family: 'Segoe UI', sans-serif;">
                        <div style="background: linear-gradient(135deg, #28a745, #20c997); color: white; padding: 15px; border-radius: 12px 12px 0 0; text-align: center;">
                            <i class="fas fa-seedling" style="font-size: 24px; margin-bottom: 8px; display: block;"></i>
                            <h5 style="margin: 0; font-weight: 600;">${name}</h5>
                            <span style="font-size: 14px; opacity: 0.9;">Irrigated Rice Areas</span>
                        </div>
                        <div style="padding: 20px; background: #f8f9fa;">
                            <div style="display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 16px;">
                                <span><i class="fas fa-ruler-combined text-primary me-2"></i>Area:</span>
                                <strong>${formatArea(area)} ha</strong>
                            </div>
                            <div style="background: linear-gradient(to right, #28a745, #ffc107); height: 8px; border-radius: 4px; margin: 15px 0;"></div>
                            <p style="color: #6c757d; font-size: 14px; margin: 0;">
                                <i class="fas fa-info-circle me-1"></i>
                                Priority area for irrigation development
                            </p>
                        </div>
                    </div>
                `;
                
                layer.bindPopup(popupContent, {
                    maxWidth: 300,
                    className: "irrigation-popup"
                });

                // Hover effects
                layer.on({
                    mouseover: function(e) {
                        const layer = e.target;
                        layer.setStyle({
                            weight: 5,
                            fillOpacity: 0.9,
                            color: "#28a745"
                        });
                        layer.bringToFront();
                    },
                    mouseout: function(e) {
                        irrigationLayer.resetStyle(e.target);
                    },
                    click: function(e) {
                        map.fitBounds(e.target.getBounds(), {padding: [20, 20]});
                    }
                });
            }

        }).addTo(map);

        // Check if features were found
        if (irrigationLayer.getLayers().length === 0) {
            showNotification(`❌ No irrigation data found for <strong>${selectedMun}</strong>`, "error");
            return;
        }

        // Success feedback + auto-zoom
        showNotification(`✅ Found <strong>${irrigationLayer.getLayers().length}</strong> areas in ${selectedMun}!`, "success");
        map.fitBounds(irrigationLayer.getBounds(), {
            padding: [30, 30],
            animate: true,
            duration: 1
        });

        // Add legend
        addIrrigationLegend();

    })
    .catch(err => {
        console.error("GeoJSON load error:", err);
        showNotification("Failed to load irrigation data!", "error");
    });
}

// 🎨 Color Functions
function getFillColor(feature) {
    const area = feature.properties?.Area_Ha || 0;
    
    // Color scale based on area size
    if (area > 5) return "#d32f2f";      // Dark red - Large areas
    if (area > 4) return "#f57c00";      // Orange - Medium-large
    if (area > 3) return "#ff9800";       // Light orange - Medium
    if (area > 0) return "#ffeb3b";       // Yellow - Small
    return "#c8e6c9";                      // Light green - Very small
}

function getBorderColor(feature) {
    const area = feature.properties?.Area_Ha || 0;
    
    if (area > 5) return "#b71c1c";
    if (area > 4) return "#e65100";
    if (area > 2) return "#f57f17";
    if (area > 0) return "#002aff";
    return "#388e3c";
}

// 📊 Format area numbers
function formatArea(area) {
    if (!area || isNaN(area)) return "N/A";
    return parseFloat(area).toLocaleString('en-US', {
        maximumFractionDigits: 1
    });
}

// 🔔 Notification system
function showNotification(message, type = "info") {
    // Remove existing notifications
    const existing = document.querySelector('.notification');
    if (existing) existing.remove();

    const colors = {
        success: { bg: '#d4edda', border: '#28a745', icon: 'fa-check-circle' },
        error: { bg: '#f8d7da', border: '#dc3545', icon: 'fa-exclamation-circle' },
        warning: { bg: '#fff3cd', border: '#ffc107', icon: 'fa-exclamation-triangle' },
        info: { bg: '#d1ecf1', border: '#17a2b8', icon: 'fa-info-circle' }
    };

    const notification = document.createElement('div');
    notification.className = `notification position-fixed top-0 end-0 m-4 p-3 rounded-3 shadow-lg fade-in-up`;
    notification.style.cssText = `
        background: ${colors[type].bg};
        border: 2px solid ${colors[type].border};
        color: ${type === 'warning' ? '#856404' : '#155724'};
        max-width: 400px;
        z-index: 9999;
        font-family: 'Segoe UI', sans-serif;
        animation: slideInRight 0.3s ease-out;
    `;

    notification.innerHTML = `
        <i class="fas ${colors[type].icon} me-2"></i>
        ${message}
        <button type="button" class="btn-close btn-close-white ms-auto d-none d-sm-inline" onclick="this.parentElement.remove()"></button>
    `;

    document.body.appendChild(notification);

    // Auto remove after 5 seconds
    setTimeout(() => {
        if (notification.parentNode) {
            notification.style.animation = 'slideOutRight 0.3s ease-in forwards';
            setTimeout(() => notification.remove(), 300);
        }
    }, 5000);
}

// 🗺️ Add Legend
function addIrrigationLegend() {
    if (document.getElementById('irrigation-legend')) return;

    const legend = L.control({position: 'bottomright'});
    legend.onAdd = function(map) {
        const div = L.DomUtil.create('div', 'irrigation-legend bg-white p-3 rounded-3 shadow border border-primary');
        div.id = 'irrigation-legend';
        div.innerHTML = `
            <div style="font-size: 14px; font-weight: 600; color: #2c3e50; margin-bottom: 12px;">
                <i class="fas fa-seedling text-success me-2"></i>Irrigation Priority
            </div>
            <div class="legend-item" style="display: flex; align-items: center; margin-bottom: 6px; font-size: 12px;">
                <div style="width: 20px; height: 20px; background: #d32f2f; border: 2px solid #b71c1c; border-radius: 3px; margin-right: 8px;"></div>
                >5 Piccolo (High)
            </div>
            <div class="legend-item" style="display: flex; align-items: center; margin-bottom: 6px; font-size: 12px;">
                <div style="width: 20px; height: 20px; background: #f57c00; border: 2px solid #e65100; border-radius: 3px; margin-right: 8px;"></div>
                4 Vegeta
            </div>
            <div class="legend-item" style="display: flex; align-items: center; margin-bottom: 6px; font-size: 12px;">
                <div style="width: 20px; height: 20px; background: #ff9800; border: 2px solid #f57f17; border-radius: 3px; margin-right: 8px;"></div>
                3 Watosi
            </div>
            <div class="legend-item" style="display: flex; align-items: center; font-size: 12px;">
                <div style="width: 20px; height: 20px; background: #c8e6c9; border: 2px solid #388e3c; border-radius: 3px; margin-right: 8px;"></div>
                <2 angkol jaworski
            </div>
        `;
        return div;
    };
    legend.addTo(map);
}
function removeIrrigationLegend(map) {
    if (irrigationLegend) {
        map.removeControl(irrigationLegend);
        irrigationLegend = null;
    }
}
// Add CSS animations for notifications
const style = document.createElement('style');
style.textContent = `
    @keyframes slideInRight {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    @keyframes slideOutRight {
        from { transform: translateX(0); opacity: 1; }
        to { transform: translateX(100%); opacity: 0; }
    }
    .irrigation-popup .leaflet-popup-content-wrapper {
        border-radius: 15px !important;
        box-shadow: 0 20px 40px rgba(0,0,0,0.15) !important;
    }
`;
document.head.appendChild(style);
function showBaha() { alert("Showing Flood (Baha) Areas 🌊"); }

// Toggle menu
document.addEventListener("DOMContentLoaded", function () {
    const menuToggle = document.getElementById("menuToggle");
    const sideMenu = document.getElementById("sideMenu");
    menuToggle.addEventListener("click", () => {
        sideMenu.classList.toggle("show");
        menuToggle.innerHTML = sideMenu.classList.contains("show") ? "✖" : "☰";
    });
});
function clearIrrigation(map) {
    document.getElementById('irrigation-legend')?.remove();
    map.removeLayer(irrigationLayer);
}
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>