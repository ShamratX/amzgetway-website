/** Default CMS document — generic empty starter (no client branding). */
export const CMS_DEFAULTS = {
  branding: {
    name: "My Site",
    mark: "M",
    logoUrl: "",
    faviconUrl: "",
  },
  header: {},
  footer: {
    tagline: "",
    servicesTitle: "",
    contactTitle: "",
    companyTitle: "",
    contactEmail1: "",
    contactEmail2: "",
    contactPhone: "",
    contactWhatsapp: "",
    contactWhatsapp2: "",
    contactSkype1: "",
    contactSkype2: "",
    contactAddress: "",
    guaranteeLabel: "",
    guaranteeText: "",
    copyrightText: "",
    ctaText: "",
  },
  layout: {
    header: {},
    footer: {},
  },
  /** Empty menus — build navigation in Admin → Menus after install */
  customMenus: {
    menus: [
      { id: "menu_primary", name: "Primary Menu", items: [] },
      { id: "menu_footer", name: "Footer Menu", items: [] },
    ],
    locations: {
      primary: "menu_primary",
      footer: "menu_footer",
    },
  },
  autoPages: {},
  customPages: [],
  pageNames: {},
  pageRedirects: {},
  pages: {},
  pageSections: {},
  pageSeo: {},
  siteMenusSeeded: false,
};

export const CMS_FIELD_META = {
  branding: [
    { key: "name", label: "Site name", type: "text" },
    { key: "mark", label: "Mark / short letter", type: "text" },
    { key: "logoUrl", label: "Logo URL", type: "url" },
    { key: "faviconUrl", label: "Favicon URL", type: "url" },
  ],
  header: [],
  footer: [
    {
      key: "tagline",
      label: "Footer tagline",
      type: "textarea",
      hint: "Text under the footer logo.",
    },
    {
      key: "servicesTitle",
      label: "Services column title",
      type: "text",
    },
    {
      key: "companyTitle",
      label: "Skype / WhatsApp column title",
      type: "text",
    },
    {
      key: "contactTitle",
      label: "Contact column title",
      type: "text",
    },
    {
      key: "contactAddress",
      label: "Address",
      type: "text",
      hint: "Footer map-marker line.",
    },
    {
      key: "contactEmail1",
      label: "Contact email 1",
      type: "text",
      hint: "Shown first in the footer Contact list (mailto link).",
    },
    {
      key: "contactEmail2",
      label: "Contact email 2",
      type: "text",
      hint: "Shown second in the footer Contact list (mailto link).",
    },
    {
      key: "contactPhone",
      label: "Phone number",
      type: "text",
      hint: "Footer phone display text and tel: link.",
    },
    {
      key: "contactWhatsapp",
      label: "WhatsApp number 1",
      type: "text",
      hint: "First WhatsApp line. Digits used for wa.me link.",
    },
    {
      key: "contactWhatsapp2",
      label: "WhatsApp number 2",
      type: "text",
    },
    {
      key: "contactSkype1",
      label: "Skype ID 1",
      type: "text",
    },
    {
      key: "contactSkype2",
      label: "Skype ID 2",
      type: "text",
    },
    {
      key: "guaranteeLabel",
      label: "Guarantee label",
      type: "text",
    },
    {
      key: "guaranteeText",
      label: "Guarantee text",
      type: "textarea",
      hint: "Use | to separate guarantee points.",
    },
    {
      key: "copyrightText",
      label: "Copyright text",
      type: "text",
      hint: "Shown after © in the footer bottom.",
    },
    {
      key: "ctaText",
      label: "Footer CTA button",
      type: "text",
    },
  ],
  /** Per-page field schemas grow from HTML scan + autoPages — keep empty here */
  pages: {},
};

/**
 * If menus exist but have zero items, leave them empty (do not inject a sample site nav).
 * Returns { menus, changed }.
 */
export function ensureSeededCustomMenus(rawMenus) {
  const m = rawMenus && typeof rawMenus === "object" ? rawMenus : {};
  const seedRoot = CMS_DEFAULTS.customMenus || {};
  const menus = Array.isArray(m.menus)
    ? m.menus.map((menu) => ({
        ...menu,
        items: Array.isArray(menu.items) ? menu.items.slice() : [],
      }))
    : [];
  const locations = {
    primary: (m.locations && m.locations.primary) || seedRoot.locations.primary,
    footer: (m.locations && m.locations.footer) || seedRoot.locations.footer,
  };

  let changed = false;
  if (!menus.some((x) => x.id === "menu_primary")) {
    menus.unshift({ id: "menu_primary", name: "Primary Menu", items: [] });
    locations.primary = "menu_primary";
    changed = true;
  }
  if (!menus.some((x) => x.id === "menu_footer")) {
    menus.push({ id: "menu_footer", name: "Footer Menu", items: [] });
    locations.footer = "menu_footer";
    changed = true;
  }

  return { menus: { menus, locations }, changed };
}

export function deepMerge(base, overlay) {
  if (!overlay || typeof overlay !== "object") return base;
  const out = Array.isArray(base) ? base.slice() : { ...base };
  for (const key of Object.keys(overlay)) {
    const bv = out[key];
    const ov = overlay[key];
    if (
      ov &&
      typeof ov === "object" &&
      !Array.isArray(ov) &&
      bv &&
      typeof bv === "object" &&
      !Array.isArray(bv)
    ) {
      out[key] = deepMerge(bv, ov);
    } else if (ov !== undefined) {
      out[key] = ov;
    }
  }
  return out;
}
