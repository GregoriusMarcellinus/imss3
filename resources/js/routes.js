const express = require('express');
const router = express.Router();
const controller = require('../controllers/controller');

// Route untuk menghapus item
router.delete('/products/:id', controller.deleteItem);

// Route untuk mengedit item
router.put('/products/:id', controller.editItem);

module.exports = router;