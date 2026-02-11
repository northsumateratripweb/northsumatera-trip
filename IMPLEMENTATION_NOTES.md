# 卡片式Tour预订系统 - 实现说明

## 已完成的更改

### 1. 数据库迁移 (Database Migration)
**文件**: `database/migrations/2026_02_09_150000_add_duration_and_trips_to_tours_table.php`

添加了两个新字段：
- `duration_days` (整数) - 旅行天数 (1-5 天)
- `trips` (JSON) - 存储 A-H 选项及其各自的价格

### 2. Tour 模型更新
**文件**: `app/Models/Tour.php`

- 添加了 `duration_days` 和 `trips` 到 `$fillable` 数组
- 添加了 `$casts` 以自动转换 `trips` 为数组

```php
protected $casts = [
    'trips' => 'array', // JSON自动转换为数组
];
```

### 3. TourController 更新
**文件**: `app/Http/Controllers/TourController.php`

#### show() 方法
- 生成 Midtrans snap token 用于预览
- 将 `$snapToken` 传递给视图

#### checkout() 方法
- 支持 `trip_id` 参数以获取特定trip的价格
- 支持 AJAX JSON 响应 (用于modal中的BOOK NOW按钮)
- 自动保存预订到数据库

### 4. Welcome 页面 (首页卡片)
**文件**: `resources/views/welcome.blade.php`

#### 卡片设计变更:
- **移除**了卡片上的按钮和价格标签
- **只显示**:
  - 位置信息 (location)
  - 标题 (title)
  - 天数 (duration_days) 带有时钟图标
- **点击卡片**触发模态框打开

#### 添加的模态框:
```html
<div id="tourModal">
  - Trip 选择 (A-H)
  - 人数选择 (1-8)
  - 总价格显示
  - 描述部分
  - 行程表部分
  - BOOK NOW 按钮 (直接Midtrans支付)
  - WHATSAPP 按钮 (联系客服)
</div>
```

#### JavaScript 功能:
- `openTourModal()` - 打开模态框并加载tour详情
- `closeTourModal()` - 关闭模态框
- `selectTrip()` - 选择trip选项
- `updatePrice()` - 动态计算总价格
- Trip 选择和人数变化时自动更新价格
- BOOK NOW 通过 AJAX 调用 checkout 端点获取 Midtrans snap token
- WHATSAPP 按钮生成包含选择信息的消息

### 5. Tour Detail 页面
**文件**: `resources/views/tour-detail.blade.php`

- 添加了 `data-description` 属性到描述部分
- 添加了 `data-itinerary` 属性到行程表部分
- 这些属性用于模态框从详情页获取内容

### 6. Midtrans 集成
- 保留了原有的 Midtrans Snap script
- 支持从模态框直接支付
- 支持从 tour-detail 页面支付

## 使用流程

### 对于管理员 (设置 Trip)

在 Filament Admin 中编辑 Tour 时:

```json
{
  "trips": {
    "a": {"price": 380000},
    "b": {"price": 430000},
    "c": {"price": 450000},
    "d": {"price": 670000},
    "e": {"price": 570000},
    "f": {"price": 520000},
    "g": {"price": 440000},
    "h": {"price": 650000}
  }
}
```

### 对于用户 (预订流程)

1. **主页首页**: 浏览卡片，看到标题、位置、天数
2. **点击卡片**: 模态框打开，显示:
   - Trip 选项 A-H (按钮)
   - 人数选择 (下拉菜单)
   - 自动计算总价格
   - 完整的描述和行程表
3. **选择选项**: 
   - 点击 Trip 按钮 (A-H)
   - 选择人数
4. **两种预订方式**:
   - **BOOK NOW**: 直接进行 Midtrans 支付
   - **WHATSAPP**: 联系客服获取更多信息

## 数据库示例

运行迁移后，手动更新 tours 表:

```sql
UPDATE tours SET duration_days = 1, trips = JSON_OBJECT(
  'a', JSON_OBJECT('price', 380000),
  'b', JSON_OBJECT('price', 430000),
  'c', JSON_OBJECT('price', 450000),
  'd', JSON_OBJECT('price', 670000),
  'e', JSON_OBJECT('price', 570000),
  'f', JSON_OBJECT('price', 520000),
  'g', JSON_OBJECT('price', 440000),
  'h', JSON_OBJECT('price', 650000)
) WHERE id = 1;
```

## 依赖项

- Laravel 10+
- Tailwind CSS
- Midtrans (snap.js)
- JavaScript (Vanilla)

## 浏览器兼容性

- Chrome/Edge (最新)
- Firefox (最新)
- Safari (最新)
- 移动浏览器支持

## 注意事项

1. **迁移需要运行**: `php artisan migrate`
2. **CSRF 保护**: 已在 AJAX 请求中添加
3. **环境变量**: 需要设置 MIDTRANS_CLIENT_KEY
4. **Trips 数据**: 需要通过 Filament Admin 或直接数据库编辑设置

## 未来改进

- [ ] 添加日期选择器
- [ ] 支持更多支付方式
- [ ] 预订确认邮件通知
- [ ] 用户账户系统
- [ ] 预订管理仪表板
