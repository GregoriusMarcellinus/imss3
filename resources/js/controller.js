const db = require('../DetailPR'); // Asumsi menggunakan database dengan models

// Fungsi untuk menghapus item
exports.deleteItem = async (req, res) => {
    try {
        const id = req.params.id;
        await db.Item.destroy({ where: { id: id } });
        res.status(200).send({ message: 'Item berhasil dihapus' });
    } catch (error) {
        res.status(500).send({ message: 'Terjadi kesalahan saat menghapus item', error: error.message });
    }
};

// Fungsi untuk mengedit item
exports.editItem = async (req, res) => {
    try {
        const id = req.params.id;
        const updatedData = req.body; // Asumsi data yang di-edit dikirimkan dalam body request
        await db.Item.update(updatedData, { where: { id: id } });
        res.status(200).send({ message: 'Item berhasil diubah' });
    } catch (error) {
        res.status(500).send({ message: 'Terjadi kesalahan saat mengubah item', error: error.message });
    }
};