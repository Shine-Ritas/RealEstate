<div>
    <x-guest.breadcrumb location="Bangkok" current="Luxury Condominium" />

    <div class="container mx-auto px-4 md:px-6 lg:px-8 py-8 md:py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Property Gallery -->
                <x-guest.property-gallery 
                    mainImage="https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?w=1200&h=800&fit=crop"
                    propertyTitle="Luxury Sky Residence"
                    status="For Sale"
                    :thumbnails="[
                        'https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?w=300&h=300&fit=crop',
                        'https://images.unsplash.com/photo-1556911220-bff31c812dba?w=300&h=300&fit=crop',
                        'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?w=300&h=300&fit=crop',
                        'https://images.unsplash.com/photo-1556911220-bff31c812dba?w=300&h=300&fit=crop'
                    ]"
                    totalImages="16"
                />

                <!-- Property Description -->
                <x-guest.property-description 
                    description="Experience luxury living in this stunning 2-bedroom condominium located in the heart of Bangkok's prestigious Sukhumvit district. This modern unit offers panoramic city views, premium finishes, and access to world-class amenities. Perfect for both residential living and investment opportunities."
                />

                <!-- Special Features -->
                <x-guest.special-features />

                <!-- Nearby Locations -->
                <x-guest.nearby-locations />
            </div>

            <!-- Right Column -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Property Summary -->
                <x-guest.property-summary 
                    title="Luxury Sky Residence"
                    location="Sukhumvit 21, Asoke, Bangkok"
                    price="฿12.5M"
                    pricePerSqm="฿125,000 per sqm"
                    bedrooms="2"
                    bathrooms="2"
                    size="100 Sqm"
                    propertyCode="#TH2024001"
                    floor="25th Floor"
                />

                <!-- Contact Information -->
                <x-guest.contact-information 
                    ownerName="Somchai Rattanakul"
                    ownerRole="Property Owner"
                    ownerImage="https://ui-avatars.com/api/?name=Somchai+Rattanakul&background=1e40af&color=fff"
                    phone="+66 89 123 4567"
                    email="@somchai_estate"
                    adminContact="+66 92 987 6543"
                />

                <!-- Property Details -->
                <x-guest.property-details 
                    developer="Sansiri Group"
                    yearBuilt="2023"
                    width="8.5m"
                    height="3.2m"
                    listedDate="Jan 15, 2024"
                />

                <!-- Schedule Viewing -->
                <x-guest.schedule-viewing />
            </div>
        </div>
    </div>
</div>
