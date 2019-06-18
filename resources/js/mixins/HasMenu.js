export default {
  data() {
    return {
      open: false
    };
  },
  methods: {
    toggleMenu() {
      this.open = !this.open;
    },
    closeMenu() {
      this.open = false;
    }
  }
};
