# test_frontend_terminal.ps1
Write-Host "========================================" -ForegroundColor Cyan
Write-Host "   VUE.JS FRONTEND - TERMINAL TEST" -ForegroundColor Cyan
Write-Host "========================================`n" -ForegroundColor Cyan

$frontendUrl = "http://localhost:3000"
$apiUrl = "http://localhost:8000/api"

Write-Host "1. TESTING FRONTEND SERVER..." -ForegroundColor Yellow
Write-Host "----------------------------" -ForegroundColor Yellow

Write-Host -NoNewline "   Server Status: "
try {
    $response = Invoke-WebRequest -Uri $frontendUrl -UseBasicParsing -TimeoutSec 3
    Write-Host "✅ RUNNING" -ForegroundColor Green
    $frontendRunning = $true
} catch {
    Write-Host "❌ NOT RUNNING" -ForegroundColor Red
    $frontendRunning = $false
}
Write-Host ""

Write-Host "2. TESTING BACKEND CONNECTION..." -ForegroundColor Yellow
Write-Host "--------------------------------" -ForegroundColor Yellow

Write-Host -NoNewline "   API Connection: "
try {
    $response = Invoke-WebRequest -Uri "$apiUrl/test" -UseBasicParsing -TimeoutSec 3
    $data = $response.Content | ConvertFrom-Json
    Write-Host "✅ CONNECTED" -ForegroundColor Green
    Write-Host "   Response: $($data.message)" -ForegroundColor Cyan
    $apiWorking = $true
} catch {
    Write-Host "❌ NOT CONNECTED" -ForegroundColor Red
    $apiWorking = $false
}
Write-Host ""

Write-Host "3. TESTING API ENDPOINTS..." -ForegroundColor Yellow
Write-Host "-------------------------" -ForegroundColor Yellow

if ($apiWorking) {
    Write-Host -NoNewline "   GET /posts: "
    try {
        $response = Invoke-WebRequest -Uri "$apiUrl/posts" -UseBasicParsing -TimeoutSec 3
        $data = $response.Content | ConvertFrom-Json
        $count = if ($data.data) { $data.data.Count } else { $data.Count }
        Write-Host "✅ $count posts" -ForegroundColor Green
    } catch {
        Write-Host "❌ FAILED" -ForegroundColor Red
    }

    Write-Host -NoNewline "   GET /categories: "
    try {
        $response = Invoke-WebRequest -Uri "$apiUrl/categories" -UseBasicParsing -TimeoutSec 3
        $data = $response.Content | ConvertFrom-Json
        Write-Host "✅ $($data.Count) categories" -ForegroundColor Green
    } catch {
        Write-Host "❌ FAILED" -ForegroundColor Red
    }

    Write-Host -NoNewline "   GET /stats: "
    try {
        $response = Invoke-WebRequest -Uri "$apiUrl/stats" -UseBasicParsing -TimeoutSec 3
        $data = $response.Content | ConvertFrom-Json
        Write-Host "✅ Posts: $($data.posts), Categories: $($data.categories)" -ForegroundColor Green
    } catch {
        Write-Host "❌ FAILED" -ForegroundColor Red
    }
}
Write-Host ""

Write-Host "4. TESTING FRONTEND ROUTES..." -ForegroundColor Yellow
Write-Host "----------------------------" -ForegroundColor Yellow

$routes = @("/", "/posts", "/posts/create")
$names = @("Home", "Posts", "Create Post")

for ($i = 0; $i -lt $routes.Length; $i++) {
    Write-Host -NoNewline "   $($names[$i]) ($($routes[$i])): "
    try {
        $response = Invoke-WebRequest -Uri "$frontendUrl$($routes[$i])" -UseBasicParsing -TimeoutSec 3
        if ($response.StatusCode -eq 200) {
            Write-Host "✅ OK" -ForegroundColor Green
        } else {
            Write-Host "⚠️  Status: $($response.StatusCode)" -ForegroundColor Yellow
        }
    } catch {
        Write-Host "❌ FAILED" -ForegroundColor Red
    }
}
Write-Host ""

Write-Host "========================================" -ForegroundColor Cyan
Write-Host "   TEST SUMMARY" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""

if ($frontendRunning) {
    Write-Host "   ✅ Frontend Server: RUNNING" -ForegroundColor Green
} else {
    Write-Host "   ❌ Frontend Server: NOT RUNNING" -ForegroundColor Red
    Write-Host "      Start with: cd frontend; npm run dev" -ForegroundColor Yellow
}

if ($apiWorking) {
    Write-Host "   ✅ Backend API: CONNECTED" -ForegroundColor Green
} else {
    Write-Host "   ❌ Backend API: NOT CONNECTED" -ForegroundColor Red
    Write-Host "      Start with: cd backend; php artisan serve" -ForegroundColor Yellow
}

Write-Host ""
if ($frontendRunning -and $apiWorking) {
    Write-Host "🎉 ALL TESTS PASSED! Your frontend is working!" -ForegroundColor Green
    Write-Host ""
    Write-Host "   Access your blog at: http://localhost:3000" -ForegroundColor Cyan
    Write-Host "   Backend API at: http://localhost:8000/api" -ForegroundColor Cyan
} else {
    Write-Host "⚠️  SOME TESTS FAILED. Please check the errors above." -ForegroundColor Red
}
Write-Host ""
Write-Host "========================================" -ForegroundColor Cyan
